<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\Business;
use App\Models\BusinessSchedule;
use App\Models\AppointmentLog;
use App\Models\Package;
use App\Models\Payment;
use App\Services\AppointmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    protected function getBusinessId(): int
    {
        if (Auth::check() && Auth::user()->business_id) {
            return Auth::user()->business_id;
        }
        $business = Business::where('is_active', true)->first();
        if (!$business) {
            abort(404, 'No active business found.');
        }
        return $business->id;
    }

    protected function loadFormData(int $businessId): array
    {
        return [
            'services' => Service::forBusiness($businessId)->active()->orderBy('sort_order')->get(),
            'packages' => Package::where('business_id', $businessId)->active()->with('services')->orderBy('sort_order')->get(),
            'employees' => User::forBusiness($businessId)->employees()->active()
                ->withCount(['assignedAppointments' => fn($q) => $q->activeBookings()])->get(),
        ];
    }

    public function create(Request $request): View
    {
        $businessId = $this->getBusinessId();

        session()->forget('success');

        $bookingToken = Str::random(32);
        session(['_booking_token' => $bookingToken]);

        $data = $this->loadFormData($businessId);

        $schedules = BusinessSchedule::where('business_id', $businessId)
            ->where('is_active', true)
            ->get()
            ->groupBy('day_of_week');

        $preselected = $request->query('service_id');

        $preselectedPackageIds = [];
        if ($request->query('package_ids')) {
            $preselectedPackageIds = (array)$request->query('package_ids');
            $preselectedPackageIds = array_map('intval', $preselectedPackageIds);
        } elseif ($request->query('package_id')) {
            $preselectedPackageIds = [(int)$request->query('package_id')];
        } elseif ($request->old('package_ids')) {
            $preselectedPackageIds = $request->old('package_ids');
        }

        return view('customer.book', array_merge($data, compact('schedules', 'preselected', 'preselectedPackageIds', 'bookingToken')));
    }

    public function store(Request $request): RedirectResponse
    {
        $businessId = $this->getBusinessId();

        // Honeypot — بوت يملأ هذا الحقل
        if ($request->filled('website')) {
            return back()->withInput()->with('error', __('Unexpected error, please try again'));
        }

        // Time check — أقل من 3 ثواني يعني بوت
        if ($request->filled('form_loaded_at')) {
            $elapsed = (int)(microtime(true) * 1000) - (int)$request->form_loaded_at;
            if ($elapsed < 3000) {
                return back()->withInput()->with('error', __('Booking too fast, please try again'));
            }
        }

        $rules = [
            'package_ids' => 'nullable|array',
            'package_ids.*' => $businessId ? Rule::exists('packages', 'id')->where('business_id', $businessId) : 'exists:packages,id',
            'service_ids' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    if (!$request->filled('service_ids') && !$request->filled('package_ids')) {
                        $fail(__('Please select at least one service or package'));
                    }
                },
            ],
            'service_ids.*' => $businessId ? Rule::exists('services', 'id')->where('business_id', $businessId) : 'exists:services,id',
            'employee_id' => [
                'nullable',
                $businessId
                    ? Rule::exists('users', 'id')->where(function ($q) use ($businessId) {
                        $q->where('business_id', $businessId)->where('role', 'employee');
                    })
                    : 'exists:users,id',
            ],
            'payment_method' => 'required|in:' . implode(',', Payment::availableMethods()),
            'shift' => 'required|in:' . implode(',', [Appointment::SHIFT_MORNING, Appointment::SHIFT_EVENING]),
            'appointment_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ];

        if (!Auth::check()) {
            $request->merge(['customer_phone' => normalizeArabicDigits($request->customer_phone)]);
            $rules['customer_name'] = 'required|string|max:255';
            $rules['customer_phone'] = ['required', 'regex:/^(?:[4569]\d{7}|\+965\d{8})$/'];

            if ($request->boolean('create_account')) {
                $rules['password'] = ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()];
                $rules['email'] = ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class];
                $rules['customer_phone'][] = 'unique:' . User::class . ',phone';
            }
        }

        $request->validate($rules, [
            'customer_phone.regex' => __('Please enter a Kuwaiti number'),
        ]);

        $phone = Auth::check() && $request->filled('customer_phone')
            ? $request->customer_phone
            : (Auth::check() ? Auth::user()->phone : $request->customer_phone);

        $data = [
            'business_id' => $businessId,
            'customer_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'shift' => $request->shift,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
            'status' => $request->employee_id ? Appointment::STATUS_ASSIGNED : Appointment::STATUS_PENDING,
        ];

        if (!Auth::check()) {
            $data['customer_name'] = $request->customer_name;
            $data['customer_phone'] = $request->customer_phone;
        } else {
            $data['customer_name'] = Auth::user()->name;
            $data['customer_phone'] = Auth::user()->phone;
        }

        $paymentMethod = $request->payment_method;

        $appointment = DB::transaction(function () use ($businessId, $data, $request, $paymentMethod, $phone) {
            $expectedToken = session('_booking_token');
            if ($expectedToken !== null) {
                if ($request->_form_token !== $expectedToken) {
                    throw new \Illuminate\Http\Exceptions\HttpResponseException(
                        back()->withInput()->with('error', __('Unexpected error, please try again'))
                    );
                }
                session()->forget('_booking_token');
            }

            $limitError = $this->appointmentService->validateBookingLimits(
                $data['customer_id'],
                $phone,
                $data['customer_id'] ? auth()->user()?->isEmployee() : false,
                $data['employee_id'],
                $data['appointment_date'],
                $data['shift'],
                withLocking: true,
            );

            if ($limitError) {
                throw new \Illuminate\Http\Exceptions\HttpResponseException(
                    back()->withInput()->with('error', __($limitError))
                );
            }

            $data['ticket_number'] = $this->appointmentService->generateTicketNumber($businessId);

            $appointment = Appointment::create($data);

            if (!Auth::check()) {
                $this->appointmentService->generateGuestToken($appointment);
            }

            if ($request->employee_id) {
                AppointmentLog::create([
                    'appointment_id' => $appointment->id,
                    'action_by' => $request->employee_id,
                    'old_status' => null,
                    'new_status' => Appointment::STATUS_ASSIGNED,
                    'notes' => 'Employee chosen at booking',
                ]);
            }

            $this->appointmentService->syncServicesAndPackages($appointment, $request);
            $this->appointmentService->applyAutoPriority($appointment);

            $this->appointmentService->createPayment($appointment, $paymentMethod);

            if (!Auth::check() && $request->boolean('create_account') && $request->filled('password')) {
                $user = User::create([
                    'name' => $data['customer_name'],
                    'phone' => $data['customer_phone'],
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'business_id' => $businessId,
                    'role' => 'customer',
                    'is_active' => true,
                ]);

                $appointment->customer_id = $user->id;
                $appointment->guest_token = null;
                $appointment->save();
            }

            return $appointment;
        });

        if (!Auth::check() && $request->boolean('create_account')) {
            $newUser = User::where('phone', $data['customer_phone'])->first();
            if ($newUser) {
                Auth::login($newUser);
            }
        }

        $token = $appointment->guest_token;

        $params = $token ? ['token' => $token] : [];

        if ($paymentMethod !== Payment::METHOD_CASH && Payment::tapIsConfigured()) {
            return redirect()->route('payment.pay', array_merge([$appointment], $params));
        }

        return redirect()->route('booking.confirmed', array_merge([$appointment], $params));
    }

    public function confirmed(Appointment $appointment, Request $request): View
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
                abort(403);
            }
        }

        $appointment->load(['packages.services', 'services', 'payment']);

        $previousCompleted = Appointment::where(function ($q) use ($appointment) {
            if ($appointment->customer_id) {
                $q->where('customer_id', $appointment->customer_id);
            } else {
                $q->where('customer_phone', $appointment->customer_phone);
            }
        })
            ->where('status', Appointment::STATUS_COMPLETED)
            ->where('id', '!=', $appointment->id)
            ->count();

        $appointment->previous_completed_count = $previousCompleted;

        return view('customer.confirmed', compact('appointment'));
    }

    public function edit(Appointment $appointment): View|RedirectResponse
    {
        session()->forget('success');

        if ($appointment->customer_id !== Auth::id()) {
            abort(403);
        }
        if (!in_array($appointment->status, Appointment::EDITABLE_STATUSES)) {
            return back()->with('error', __('Cannot edit this booking'));
        }
        if (!$appointment->isEditable()) {
            return back()->with('error', __('This booking is paid and cannot be edited. Please contact support'));
        }

        $businessId = $this->getBusinessId();
        $data = $this->loadFormData($businessId);
        $appointment->load('packages');
        return view('customer.edit', array_merge($data, compact('appointment')));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->customer_id !== Auth::id()) {
            abort(403);
        }
        if (!in_array($appointment->status, Appointment::EDITABLE_STATUSES)) {
            return back()->with('error', __('Cannot edit this booking'));
        }
        if (!$appointment->isEditable()) {
            return back()->with('error', __('This booking is paid and cannot be edited. Please contact support'));
        }

        $request->validate([
            'service_ids' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    if (!$request->filled('service_ids') && !$request->filled('package_ids')) {
                        $fail(__('Please select at least one service or package'));
                    }
                },
            ],
            'service_ids.*' => 'exists:services,id',
            'package_ids' => 'nullable|array',
            'package_ids.*' => 'exists:packages,id',
            'employee_id' => 'nullable|exists:users,id',
            'shift' => 'required|in:' . implode(',', [Appointment::SHIFT_MORNING, Appointment::SHIFT_EVENING]),
            'appointment_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $appointment->update([
            'shift' => $request->shift,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
        ]);

        if ($request->has('employee_id')) {
            $this->appointmentService->syncEmployee(
                $appointment,
                $request->employee_id ?: null,
                $appointment->employee_id,
                Auth::id(),
            );
        }

        $this->appointmentService->syncServicesAndPackages($appointment, $request);
        $this->appointmentService->applyAutoPriority($appointment);

        if ($appointment->payment) {
            $appointment->payment->update([
                'amount' => $appointment->total_price,
            ]);
        }

        $appointment->load(['employee']);

        AppointmentLog::create([
            'appointment_id' => $appointment->id,
            'action_by' => Auth::id(),
            'old_status' => null,
            'new_status' => $appointment->status,
            'notes' => 'Booking updated',
        ]);

        return redirect()->route('customer.appointment.show', $appointment)
            ->with('success', __('Booking updated'));
    }

    public function guestEdit(Request $request, Appointment $appointment): RedirectResponse|View
    {
        if ($appointment->business_id !== $this->getBusinessId()) {
            abort(403);
        }

        session()->forget('success');

        if (!in_array($appointment->status, Appointment::EDITABLE_STATUSES)) {
            return redirect()->route('track')->with('error', __('Cannot edit this booking'));
        }

        if (!$appointment->isEditable()) {
            return redirect()->route('track')->with('error', __('This booking is paid and cannot be edited. Please contact support'));
        }

        $phone = $request->query('phone');
        if (!$phone || $phone !== $appointment->customer_phone) {
            return redirect()->route('track')->with('error', __('No booking found with this ticket and phone'));
        }

        if (!$appointment->guest_token) {
            return redirect()->route('track')->with('error', __('No booking found with this ticket and phone'));
        }
        if (!hash_equals((string)$appointment->guest_token, (string)$request->query('token'))) {
            return redirect()->route('track')->with('error', __('No booking found with this ticket and phone'));
        }

        $businessId = $this->getBusinessId();
        $data = $this->loadFormData($businessId);
        $appointment->load('packages');
        return view('customer.guest-edit', array_merge($data, compact('appointment', 'phone')));
    }

    public function guestUpdate(Request $request, Appointment $appointment): RedirectResponse|View
    {
        if ($appointment->business_id !== $this->getBusinessId()) {
            abort(403);
        }

        if (!in_array($appointment->status, Appointment::EDITABLE_STATUSES)) {
            return back()->with('error', __('Cannot edit this booking'));
        }

        $request->merge(['phone' => normalizeArabicDigits($request->phone)]);

        if ($request->phone !== $appointment->customer_phone) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }

        if (!$appointment->guest_token) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }
        if (!hash_equals((string)$appointment->guest_token, (string)$request->input('token'))) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }

        if (!$appointment->isEditable()) {
            return back()->with('error', __('This booking is paid and cannot be edited. Please contact support'));
        }

        $request->validate([
            'service_ids' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    if (!$request->filled('service_ids') && !$request->filled('package_ids')) {
                        $fail(__('Please select at least one service or package'));
                    }
                },
            ],
            'service_ids.*' => 'exists:services,id',
            'package_ids' => 'nullable|array',
            'package_ids.*' => 'exists:packages,id',
            'employee_id' => 'nullable|exists:users,id',
            'shift' => 'required|in:' . implode(',', [Appointment::SHIFT_MORNING, Appointment::SHIFT_EVENING]),
            'appointment_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
            'phone' => ['required', 'regex:/^(?:[4569]\d{7}|\+965\d{8})$/'],
        ], [
            'phone.regex' => __('Please enter a Kuwaiti number'),
        ]);

        $appointment->update([
            'shift' => $request->shift,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
        ]);

        if ($request->has('employee_id')) {
            $this->appointmentService->syncEmployee(
                $appointment,
                $request->employee_id ?: null,
                $appointment->employee_id,
                null,
            );
        }

        $this->appointmentService->syncServicesAndPackages($appointment, $request);
        $this->appointmentService->applyAutoPriority($appointment);

        if ($appointment->payment) {
            $appointment->payment->update([
                'amount' => $appointment->total_price,
            ]);
        }

        $appointment->load(['employee']);

        AppointmentLog::create([
            'appointment_id' => $appointment->id,
            'action_by' => null,
            'old_status' => null,
            'new_status' => $appointment->status,
            'notes' => 'Booking updated',
        ]);

        session()->now('success', __('Booking updated'));

        return view('track-result', compact('appointment'));
    }

    protected function doCancel(Appointment $appointment, Request $request, ?int $actionBy, string $redirectRoute): RedirectResponse
    {
        if (!in_array($appointment->status, Appointment::EDITABLE_STATUSES)) {
            return back()->with('error', __('Cannot cancel this booking'));
        }

        if (!$appointment->isEditable()) {
            return back()->with('error', __('This booking is paid and cannot be cancelled. Please contact support'));
        }

        $request->validate(['cancel_reason' => 'nullable|string|max:500']);

        $oldStatus = $appointment->status;
        $appointment->update([
            'status' => Appointment::STATUS_CANCELLED,
            'cancel_reason' => $request->cancel_reason,
        ]);

        AppointmentLog::create([
            'appointment_id' => $appointment->id,
            'action_by' => $actionBy,
            'old_status' => $oldStatus,
            'new_status' => Appointment::STATUS_CANCELLED,
            'notes' => $request->cancel_reason ?: 'Booking cancelled',
        ]);

        return redirect()->route($redirectRoute)
            ->with('success', __('Booking cancelled'));
    }

    public function guestCancel(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->business_id !== $this->getBusinessId()) {
            abort(403);
        }

        if ($request->phone !== $appointment->customer_phone) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }

        if (!$appointment->guest_token) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }
        if (!hash_equals((string)$appointment->guest_token, (string)$request->input('token'))) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }

        return $this->doCancel($appointment, $request, null, 'home');
    }

    public function customerCancel(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->customer_id !== Auth::id()) {
            abort(403);
        }

        return $this->doCancel($appointment, $request, Auth::id(), 'customer.appointments');
    }
}
