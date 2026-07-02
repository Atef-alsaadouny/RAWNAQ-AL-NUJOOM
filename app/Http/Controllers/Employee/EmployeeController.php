<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentLog;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * New assignments notification (polled every 7 seconds)
     */
    public function recentNotifications(Request $request): JsonResponse
    {
        $employeeId = Auth::id();
        $since = $request->input('since', now()->subMinutes(2)->toDateTimeString());

        $assignedIds = DB::table('appointment_employee')
            ->where('employee_id', $employeeId)
            ->pluck('appointment_id');

        $bookings = Appointment::where(function ($q) use ($employeeId, $assignedIds) {
                $q->where('appointments.employee_id', $employeeId)
                  ->orWhereIn('appointments.id', $assignedIds);
            })
            ->where(function ($q) use ($since) {
                $q->where('appointments.created_at', '>', $since)
                  ->orWhere('appointments.updated_at', '>', $since);
            })
            ->with(['services', 'packages'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'ticket' => $b->ticket_number,
                    'customer_name' => $b->customer_name,
                    'customer_phone' => $b->customer_phone,
                    'service_names' => $b->services->pluck('name')->take(2)->implode(' + '),
                    'display_services' => $b->display_services,
                    'total' => (int)$b->total_price,
                    'created_at' => $b->created_at->diffForHumans(),
                    'date' => $b->appointment_date->format('Y-m-d'),
                    'shift' => $b->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening'),
                ];
            });

        return response()->json([
            'bookings' => $bookings,
            'server_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Employee dashboard - today's and upcoming appointments with stats
     */
    public function dashboard(): View
    {
        Appointment::expirePast();

        $employeeId = Auth::id();
        $today = now()->toDateString();

        $todayAppointments = Appointment::forEmployee($employeeId)
            ->whereDate('appointment_date', $today)
            ->with(['services', 'rating'])
            ->orderBy('assigned_time')
            ->get();

        $upcomingAppointments = Appointment::forEmployee($employeeId)
            ->whereDate('appointment_date', '>=', $today)
            ->whereIn('status', [Appointment::STATUS_ASSIGNED, Appointment::STATUS_IN_PROGRESS])
            ->with(['services'])
            ->orderBy('appointment_date')
            ->orderBy('assigned_time')
            ->take(10)
            ->get();

        $stats = [
            'today_count' => $todayAppointments->count(),
            'completed_today' => $todayAppointments->where('status', Appointment::STATUS_COMPLETED)->count(),
            'pending' => $todayAppointments->whereIn('status', [Appointment::STATUS_ASSIGNED, Appointment::STATUS_IN_PROGRESS])->count(),
        ];

        return view('employee.dashboard', compact('todayAppointments', 'upcomingAppointments', 'stats'));
    }

    public function todayAppointments(): View
    {
        $employeeId = Auth::id();
        $today = now()->toDateString();

        $todayAppointments = Appointment::forEmployee($employeeId)
            ->whereDate('appointment_date', $today)
            ->with(['services', 'rating'])
            ->orderBy('assigned_time')
            ->get();

        return view('employee.partials.today-appointments', compact('todayAppointments'));
    }

    /**
     * All employee appointments with status/date filter and pagination
     */
    public function appointments(Request $request): View
    {
        Appointment::expirePast();

        $employeeId = Auth::id();
        
        $query = Appointment::forEmployee($employeeId)
            ->where(function ($q) {
                $q->whereDate('appointment_date', '>=', now()->startOfDay())
                  ->orWhereNotIn('status', Appointment::EDITABLE_STATUSES);
            })
            ->with(['services', 'rating']);

        if ($request->filled('status')) {
            if ($request->status === Appointment::STATUS_EXPIRED) {
                $query->whereIn('status', Appointment::EDITABLE_STATUSES)->whereDate('appointment_date', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date')
            ->orderBy('assigned_time')
            ->paginate(20);

        return view('employee.appointments', compact('appointments'));
    }

    /**
     * Booking detail page - verifies the booking belongs to this employee
     */
    public function show(Appointment $appointment): View
    {
        $appointment->load('employees');
        if ($appointment->business_id !== Auth::user()->business_id) {
            abort(403);
        }
        if ($appointment->employee_id !== Auth::id() && !$appointment->employees->contains('id', Auth::id())) {
            abort(403);
        }
        $appointment->load(['services', 'customer', 'rating', 'logs.actionBy']);
        return view('employee.show', compact('appointment'));
    }

    /**
     * Update booking status (assigned → in_progress → completed)
     */
    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment->load('employees');
        if ($appointment->business_id !== Auth::user()->business_id) {
            abort(403);
        }
        if ($appointment->employee_id !== Auth::id() && !$appointment->employees->contains('id', Auth::id())) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:' . implode(',', [Appointment::STATUS_IN_PROGRESS, Appointment::STATUS_COMPLETED]),
        ]);

        if ($request->status === Appointment::STATUS_IN_PROGRESS && !$appointment->appointment_date?->isToday()) {
            return back()->with('error', __('Cannot start a service that is not scheduled for today'));
        }

        $allowedTransitions = [
            Appointment::STATUS_ASSIGNED => [Appointment::STATUS_IN_PROGRESS],
            Appointment::STATUS_IN_PROGRESS => [Appointment::STATUS_COMPLETED],
        ];

        $statusMap = [Appointment::STATUS_ASSIGNED => 'Assigned', Appointment::STATUS_IN_PROGRESS => 'In Progress', Appointment::STATUS_COMPLETED => 'Completed'];

        $currentStatus = $appointment->status;
        if (!isset($allowedTransitions[$currentStatus]) || !in_array($request->status, $allowedTransitions[$currentStatus])) {
            $from = $statusMap[$currentStatus] ?? $currentStatus;
            $to = $statusMap[$request->status] ?? $request->status;
            return back()->with('error', __("Cannot change status from :from to :to", ['from' => __($from), 'to' => __($to)]));
        }

        $data = ['status' => $request->status];
        if ($request->status === Appointment::STATUS_COMPLETED) {
            $data['completed_at'] = now();
        }

        $appointment->update($data);

        AppointmentLog::create([
            'appointment_id' => $appointment->id,
            'action_by' => Auth::id(),
            'old_status' => $currentStatus,
            'new_status' => $request->status,
        ]);

        $status = __($statusMap[$request->status] ?? $request->status);
        return back()->with('success', __("Booking status updated to :status", ['status' => $status]));
    }

    /**
     * Employee ratings with average calculation
     */
    public function ratings(): View
    {
        $ratings = Rating::where('employee_id', Auth::id())
            ->with(['appointment.services', 'customer'])
            ->latest()
            ->paginate(20);

        $avgRating = Rating::where('employee_id', Auth::id())->avg('rating') ?? 0;

        return view('employee.ratings', compact('ratings', 'avgRating'));
    }

    /**
     * Available bookings (pending, unassigned) for the employee to claim
     */
    public function available(Request $request): View
    {
        $businessId = Auth::user()->business_id;

        $query = Appointment::where('business_id', $businessId)
            ->where('status', Appointment::STATUS_PENDING)
            ->whereNull('employee_id')
            ->whereDoesntHave('employees')
            ->with(['services']);

        $date = $request->filled('date') ? $request->date : now()->format('Y-m-d');
        $query->whereDate('appointment_date', $date);

        $appointments = $query->orderBy('appointment_date')
            ->orderBy('assigned_time')
            ->paginate(20);

        return view('employee.available', compact('appointments'));
    }

    /**
     * Employee claims an available booking for themselves
     */
    public function claim(Appointment $appointment): RedirectResponse
    {
        if ($appointment->business_id !== Auth::user()->business_id) {
            abort(403);
        }

        $claimed = DB::transaction(function () use ($appointment) {
            $locked = Appointment::where('id', $appointment->id)
                ->where('business_id', $appointment->business_id)
                ->lockForUpdate()
                ->first();

            if (!$locked || $locked->status !== Appointment::STATUS_PENDING || $locked->employee_id !== null) {
                return null;
            }

            $oldStatus = $locked->status;

            $locked->update([
                'employee_id' => Auth::id(),
                'status' => Appointment::STATUS_ASSIGNED,
            ]);

            $locked->employees()->syncWithoutDetaching([Auth::id()]);

            AppointmentLog::create([
                'appointment_id' => $locked->id,
                'action_by' => Auth::id(),
                'old_status' => $oldStatus,
                'new_status' => Appointment::STATUS_ASSIGNED,
                'notes' => 'Employee claimed the booking',
            ]);

            return $locked;
        });

        if (!$claimed) {
            return back()->with('error', __('This booking is not available'));
        }

        return redirect()->route('employee.dashboard')
            ->with('success', __('Booking taken') . ' ' . $claimed->ticket_number);
    }
}
