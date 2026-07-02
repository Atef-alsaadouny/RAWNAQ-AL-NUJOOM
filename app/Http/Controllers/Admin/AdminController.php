<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected function dashboardStats(int $businessId, string $today): array
    {
        return [
            'total_appointments' => Appointment::forBusiness($businessId)->count(),
            'today_appointments' => Appointment::forBusiness($businessId)->whereDate('appointment_date', $today)->count(),
            'pending_appointments' => Appointment::forBusiness($businessId)->pending()->count(),
            'unassigned' => Appointment::forBusiness($businessId)->where('status', Appointment::STATUS_PENDING)->whereNull('employee_id')->count(),
            'total_employees' => User::forBusiness($businessId)->employees()->count(),
            'total_services' => Service::forBusiness($businessId)->count(),
            'total_ratings' => Rating::whereHas('appointment', fn($q) => $q->forBusiness($businessId))->count(),
            'avg_rating' => Rating::whereHas('appointment', fn($q) => $q->forBusiness($businessId))->avg('rating') ?? 0,
        ];
    }

    protected function unassignedAppointments($businessId)
    {
        return Appointment::forBusiness($businessId)
            ->where('status', Appointment::STATUS_PENDING)
            ->whereNull('employee_id')
            ->whereDate('appointment_date', '>=', now())
            ->with(['services', 'packages'])
            ->orderBy('appointment_date')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * عرض لوحة التحكم الرئيسية للمشرف
     * تعرض إحصائيات الحجوزات والموظفين والتقييمات
     */
    public function dashboard(Request $request)
    {
        Appointment::expirePast();

        $businessId = Auth::user()->business_id;
        $today = now()->toDateString();

        $stats = $this->dashboardStats($businessId, $today);

        $recentAppointments = Appointment::forBusiness($businessId)
            ->with(['customer', 'employee', 'employees', 'services', 'rating'])
            ->latest()
            ->take(10)
            ->get();

        $unassignedAppointments = $this->unassignedAppointments($businessId);

        $employees = User::forBusiness($businessId)->employees()->active()->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments', 'unassignedAppointments', 'employees'));
    }

    /**
     * عرض صفحة الملف الشخصي للمشرف
     */
    public function profile()
    {
        return view('admin.profile');
    }

    /**
     * حجوزات جديدة (آخر 60 ثانية) — للتنبيهات اللحظية
     */
    public function recentBookings(Request $request)
    {
        $businessId = Auth::user()->business_id;
        $since = $request->input('since', now()->subMinutes(2)->toDateTimeString());

        $bookings = Appointment::forBusiness($businessId)
            ->where('created_at', '>', $since)
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
     * بيانات dashbaord كاملة (JSON) للتحديث التلقائي
     */
    public function dashboardData()
    {
        Appointment::expirePast();

        $businessId = Auth::user()->business_id;
        $today = now()->toDateString();

        $stats = $this->dashboardStats($businessId, $today);
        $statsForJson = [
            'pending_appointments' => $stats['pending_appointments'],
            'today_appointments' => $stats['today_appointments'],
            'unassigned' => $stats['unassigned'],
            'total_employees' => $stats['total_employees'],
            'avg_rating' => round($stats['avg_rating'], 1),
        ];

        $recentAppointments = Appointment::forBusiness($businessId)
            ->with(['customer', 'employee', 'employees', 'services', 'rating'])
            ->latest()
            ->take(10)
            ->get();

        $unassignedAppointments = $this->unassignedAppointments($businessId);

        $employees = User::forBusiness($businessId)->employees()->active()->get(['id', 'name']);

        $recentHtml = view('admin.partials.dashboard-recent', compact('recentAppointments'))->render();
        $statsHtml = view('admin.partials.dashboard-stats', compact('stats'))->render();
        $unassignedHtml = view('admin.partials.dashboard-unassigned', compact('unassignedAppointments', 'employees'))->render();

        return response()->json([
            'stats' => $statsForJson,
            'stats_html' => $statsHtml,
            'unassigned_html' => $unassignedHtml,
            'recent_html' => $recentHtml,
            'server_time' => now()->toDateTimeString(),
        ]);
    }
}
