<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->customer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $appointment->load('employees');

        Rating::create([
            'appointment_id' => $appointment->id,
            'customer_id' => Auth::id(),
            'employee_id' => $appointment->employee_id ?: ($appointment->employees->first()?->id),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('customer.appointment.show', $appointment)
            ->with('success', __('Your rating has been submitted, thank you!'));
    }

    protected function getBusinessId(): int
    {
        $business = \App\Models\Business::where('is_active', true)->first();
        if (!$business) {
            abort(404, 'No active business found.');
        }
        return $business->id;
    }

    public function guestStore(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->business_id !== $this->getBusinessId()) {
            abort(403);
        }

        if ($appointment->status !== Appointment::STATUS_COMPLETED) {
            return back()->with('error', __('Cannot rate a booking that is not completed'));
        }

        if ($appointment->rating) {
            return back()->with('error', __('This booking has already been rated'));
        }

        $phone = $request->input('phone');
        if (!$phone || $phone !== $appointment->customer_phone) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }

        if ($appointment->guest_token && !hash_equals((string)$appointment->guest_token, (string)$request->input('token'))) {
            return back()->with('error', __('No booking found with this ticket and phone'));
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $appointment->load('employees');

        Rating::create([
            'appointment_id' => $appointment->id,
            'customer_id' => null,
            'employee_id' => $appointment->employee_id ?: ($appointment->employees->first()?->id),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('track')
            ->with('success', __('Your rating has been submitted, thank you!'));
    }
}
