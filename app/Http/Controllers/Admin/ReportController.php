<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $businessId = Auth::user()->business_id;

        $query = Appointment::forBusiness($businessId);

        if ($request->filled('from')) {
            $query->whereDate('appointment_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('appointment_date', '<=', $request->to);
        }

        $appointments = $query->with(['employee', 'services'])->get();

        $totalAppointments = $appointments->count();
        $completed = $appointments->where('status', Appointment::STATUS_COMPLETED)->count();
        $cancelled = $appointments->where('status', Appointment::STATUS_CANCELLED)->count();
        $pending = $appointments->whereIn('status', Appointment::EDITABLE_STATUSES)->count();

        // أسباب الإلغاء الأكثر تكراراً
        $cancelReasons = Appointment::forBusiness($businessId)
            ->where('status', Appointment::STATUS_CANCELLED)
            ->whereNotNull('cancel_reason')
            ->when($request->filled('from'), fn($q) => $q->whereDate('appointment_date', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('appointment_date', '<=', $request->to))
            ->select('cancel_reason', DB::raw('count(*) as total'))
            ->groupBy('cancel_reason')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $employeeStats = User::where('business_id', $businessId)
            ->where('role', 'employee')
            ->withCount([
                'assignedAppointments',
                'assignedAppointments as completed_count' => fn($q) => $q->where('status', Appointment::STATUS_COMPLETED),
            ])
            ->get()
            ->map(function ($emp) {
                $emp->avg_rating = $emp->ratings()->avg('rating') ?? 0;
                return $emp;
            });

        return view('admin.reports.index', compact(
            'totalAppointments', 'completed', 'cancelled', 'pending', 'employeeStats', 'cancelReasons'
        ));
    }
}
