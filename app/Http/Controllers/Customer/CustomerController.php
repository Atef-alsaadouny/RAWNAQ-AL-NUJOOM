<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function appointments(): View
    {
        $appointments = Appointment::where('customer_id', Auth::id())
            ->with(['services', 'employee', 'rating'])
            ->orderBy('appointment_date')
            ->orderBy('created_at')
            ->paginate(Appointment::MAX_PAGE_SIZE);

        return view('customer.appointments', compact('appointments'));
    }

    public function show(Appointment $appointment): View
    {
        if ($appointment->customer_id !== Auth::id()) {
            abort(403);
        }
        $appointment->load(['services', 'employee', 'rating', 'logs.actionBy', 'packages', 'payment']);
        return view('customer.show', compact('appointment'));
    }

    public function profile(): View
    {
        $user = auth()->user();

        $totalBookings = Appointment::where('customer_id', $user->id)->count();
        $activeBookings = Appointment::where('customer_id', $user->id)
            ->whereIn('status', Appointment::ACTIVE_STATUSES)
            ->count();
        $completedBookings = Appointment::where('customer_id', $user->id)
            ->where('status', Appointment::STATUS_COMPLETED)
            ->count();

        $upcomingAppointment = Appointment::where('customer_id', $user->id)
            ->whereIn('status', Appointment::ACTIVE_STATUSES)
            ->with(['services', 'employee'])
            ->orderBy('appointment_date')
            ->first();

        $recentBookings = Appointment::where('customer_id', $user->id)
            ->with(['services'])
            ->latest()
            ->take(3)
            ->get();

        return view('customer.profile', compact(
            'user', 'totalBookings', 'activeBookings', 'completedBookings', 'upcomingAppointment', 'recentBookings'
        ));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $request->merge(['phone' => normalizeArabicDigits($request->phone)]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(?:[4569]\d{7}|\+965\d{8})$/', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ], [
            'phone.regex' => __('Please enter a Kuwaiti number'),
        ]);

        $user->update($validated);

        return back()->with('success', __('Your data has been updated successfully'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['new_password']),
            'remember_token' => Str::random(60),
        ]);

        $request->session()->regenerate();
        Auth::logoutOtherDevices($validated['new_password']);

        return back()->with('success', __('Password changed successfully'));
    }
}
