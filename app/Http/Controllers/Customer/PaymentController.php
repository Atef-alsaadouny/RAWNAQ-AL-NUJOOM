<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use App\Services\TapPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    protected TapPaymentService $tap;

    public function __construct(TapPaymentService $tap)
    {
        $this->tap = $tap;
    }

    /**
     * صفحة الدفع للحجز الموجود
     */
    public function pay(Appointment $appointment, Request $request): RedirectResponse|View
    {
        if (Auth::check()) {
            if ($appointment->customer_id !== Auth::id()) {
                abort(403);
            }
        } else {
            if (!$appointment->guest_token) {
                abort(403);
            }
            if (!hash_equals((string)$appointment->guest_token, (string)$request->query('token'))) {
                return redirect()->route('track')->with('error', __('Booking not found'));
            }
        }

        if ($redirect = $this->handleAlreadyPaid($appointment)) {
            return $redirect;
        }

        $appointment->load(['packages.services', 'services']);

        return view('payment.pay', compact('appointment'));
    }

    /**
     * معالجة الدفع — إنشاء charge مع Tap
     */
    public function process(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($redirect = $this->handleAlreadyPaid($appointment)) {
            return $redirect;
        }

        if (Auth::check()) {
            if ($appointment->customer_id !== Auth::id()) {
                abort(403);
            }
        } else {
            if (!$appointment->guest_token) {
                abort(403);
            }
            if (!hash_equals((string)$appointment->guest_token, (string)$request->input('token'))) {
                return back()->with('error', __('Invalid payment request'));
            }
        }

        $request->validate([
            'method' => 'required|in:' . implode(',', [Payment::METHOD_KNET, Payment::METHOD_APPLE_PAY, Payment::METHOD_GOOGLE_PAY]),
        ]);

        $method = $request->method;
        $amount = $appointment->total_price;

        if ($amount <= 0) {
            return back()->with('error', __('Booking amount is zero, cannot pay'));
        }

        $payment = DB::transaction(function () use ($appointment, $method, $amount) {
            $existing = Payment::where('appointment_id', $appointment->id)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                if ($existing->isPaid()) {
                    return null;
                }
                return $existing;
            }

            return Payment::create([
                'appointment_id' => $appointment->id,
                'method' => $method,
                'amount' => $amount,
                'status' => Payment::STATUS_UNPAID,
            ]);
        });

        if ($payment === null) {
            return back()->with('error', __('This booking is already paid'));
        }

        if (empty(config('services.tap.secret_key'))) {
            Log::critical('Tap payment secret key is missing', [
                'appointment_id' => $appointment->id,
            ]);
            return back()->with('error', __('Payment system is not configured. Please contact support.'));
        }

        $result = $this->tap->createCharge($appointment, $method);

        if (!$result['success']) {
            return back()->with('error', $result['message'] ?? __('Payment failed'));
        }

        $payment->update([
            'tap_charge_id' => $result['charge_id'],
            'transaction_id' => $result['transaction_id'] ?? $result['charge_id'],
        ]);

        if (!empty($result['redirect_url'])) {
            return redirect()->away($result['redirect_url']);
        }

        $payment->update([
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
        ]);

        $params = $this->guestTokenParams($appointment);
        return redirect()->route('booking.confirmed', array_merge([$appointment], $params))
            ->with('success', __('Payment successful'));
    }

    /**
     * Callback من Tap بعد الدفع
     */
    public function callback(Request $request): RedirectResponse
    {
        // Handle both GET (user redirect) and POST (server notification)
        $appointmentId = $request->input('appointment', $request->query('appointment'));
        $status = $request->input('status', $request->query('status'));
        $chargeId = $request->input('charge_id', $request->query('charge_id'));
        $isPost = $request->isMethod('post');
        if ($chargeId && $isPost) {
            $body = $request->json()?->all() ?? [];
            $chargeId = $body['id'] ?? ($body['charge_id'] ?? $chargeId);
            $status = $body['status'] ?? ($body['response']['status'] ?? $status);
            // POST (webhook): always trust reference.order from Tap, not user input
            $appointmentId = $body['reference']['order'] ?? $appointmentId;
        }

        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            Log::warning('Tap callback for unknown appointment', ['appointment_id' => $appointmentId]);
            return redirect()->route('home')->with('error', __('Booking not found'));
        }

        // For GET (user redirect), verify access before processing
        if (!$isPost) {
            $this->verifyAppointmentAccess($appointment, $request);
        }

        $payment = $appointment->payment;

        if (!$payment) {
            Log::warning('Tap callback for appointment without payment', ['appointment_id' => $appointment->id]);
            return redirect()->route('track')->with('error', __('No payment found for this booking'));
        }

        if ($payment->isPaid()) {
            return $this->redirectToConfirmed($appointment, 'Payment successful');
        }

        if ($status === 'cancel') {
            $payment->update(['status' => Payment::STATUS_UNPAID]);
            return $this->redirectToConfirmed($appointment, 'Payment cancelled', 'error');
        }

        if ($status === 'success' && $chargeId) {
            if (empty(config('services.tap.secret_key'))) {
                Log::critical('Tap callback attempted without secret key', [
                    'appointment_id' => $appointment->id,
                    'charge_id' => $chargeId,
                ]);
                return redirect()->route('home')->with('error', __('Payment verification failed'));
            }

            $result = $this->tap->retrieveCharge($chargeId);

            if ($result['success'] && $result['status'] === 'CAPTURED') {
                $capturedAmount = $result['amount'] ?? 0;
                $expectedAmount = (float) $payment->amount;

                if (abs((float) $capturedAmount - (float) $expectedAmount) > 0.01) {
                    Log::warning('Payment amount mismatch', [
                        'appointment_id' => $appointment->id,
                        'expected' => $expectedAmount,
                        'captured' => $capturedAmount,
                        'charge_id' => $chargeId,
                    ]);
                    $payment->update(['status' => Payment::STATUS_FAILED]);
                    return $this->redirectToConfirmed($appointment, 'Payment verification failed. Please contact support.', 'error');
                }

                $payment->update([
                    'status' => Payment::STATUS_PAID,
                    'transaction_id' => $result['transaction_id'],
                    'paid_at' => now(),
                ]);

                return $this->redirectToConfirmed($appointment, 'Payment successful');
            }

            $payment->update(['status' => Payment::STATUS_FAILED]);
            return $this->redirectToConfirmed($appointment, 'Payment failed, please try again', 'error');
        }

        return $this->redirectToConfirmed($appointment, '');
    }

    private function verifyAppointmentAccess(Appointment $appointment, Request $request): void
    {
        if (Auth::check()) {
            if ($appointment->customer_id !== Auth::id()) {
                abort(403);
            }
        } else {
            $token = $request->input('token', $request->query('token'));
            if (!$appointment->guest_token || !hash_equals((string)$appointment->guest_token, (string)$token)) {
                abort(403);
            }
        }
    }

    /**
     * نجاح الدفع (صفحة منفصلة)
     */
    public function success(Appointment $appointment): View
    {
        return view('payment.success', compact('appointment'));
    }

    /**
     * إلغاء الدفع (صفحة منفصلة)
     */
    public function cancel(Appointment $appointment): View
    {
        return view('payment.cancel', compact('appointment'));
    }

    private function guestTokenParams(Appointment $appointment): array
    {
        return $appointment->guest_token ? ['token' => $appointment->guest_token] : [];
    }

    private function redirectToConfirmed(Appointment $appointment, string $message, string $type = 'success'): RedirectResponse
    {
        $params = array_merge([$appointment], $this->guestTokenParams($appointment));
        return redirect()->route('booking.confirmed', $params)->with($type, __($message));
    }

    private function handleAlreadyPaid(Appointment $appointment): RedirectResponse|null
    {
        if ($appointment->payment && $appointment->payment->isPaid()) {
            return redirect()->route('booking.confirmed', array_merge([$appointment], $this->guestTokenParams($appointment)))
                ->with('info', __('This booking has already been paid'));
        }
        return null;
    }
}
