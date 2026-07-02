<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\AuthorizesBusiness;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use App\Models\Package;
use App\Models\AppointmentLog;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    use AuthorizesBusiness;
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }
    /**
     * عرض قائمة الحجوزات مع إمكانية التصفية حسب الحالة والموظف والأولوية والتاريخ
     */
    public function index(Request $request)
    {
        Appointment::expirePast();

        $businessId = Auth::user()->business_id;

        // بدء استعلام الحجوزات مع تحميل العلاقات المرتبطة (العميل، الموظف، الخدمة)
        $query = Appointment::forBusiness($businessId)
            ->with(['customer', 'employee', 'services', 'package', 'packages', 'payment', 'rating']);

        // تطبيق التصفية حسب الحالة إذا تم إرسالها
        if ($request->filled('status')) {
            if ($request->status === Appointment::STATUS_EXPIRED) {
                $query->whereIn('status', Appointment::EDITABLE_STATUSES)->whereDate('appointment_date', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }
        // تطبيق التصفية حسب الموظف إذا تم إرسالها
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        // تطبيق التصفية حسب الأولوية إذا تم إرسالها
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        // تطبيق التصفية حسب التاريخ إذا تم إرسالها
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // جلب الحجوزات مقسمة على صفحات مع ترتيب حسب تاريخ الحجز
        $appointments = $query->orderBy('appointment_date')->orderBy('assigned_time')->paginate(20)->withQueryString();
        // جلب قائمة الموظفين لعرضها في قائمة التصفية
        $employees = User::where('business_id', $businessId)->where('role', 'employee')->get();

        return view('admin.appointments.index', compact('appointments', 'employees'));
    }

    /**
     * عرض نموذج إنشاء حجز جديد مع قائمة الخدمات النشطة
     */
    public function create()
    {
        $businessId = Auth::user()->business_id;
        $services = Service::forBusiness($businessId)->active()->orderBy('sort_order')->get();
        $packages = Package::where('business_id', $businessId)->active()->with('services')->orderBy('sort_order')->get();
        $employees = User::forBusiness($businessId)->employees()->active()->get();
        return view('admin.appointments.create', compact('services', 'packages', 'employees'));
    }

    /**
     * حفظ حجز جديد في قاعدة البيانات
     */
    public function store(StoreAppointmentRequest $request)
    {
        $businessId = Auth::user()->business_id;

        $request->merge(['customer_phone' => normalizeArabicDigits($request->customer_phone)]);

        $validated = $request->validated();

        $appointment = DB::transaction(function () use ($businessId, $validated, $request) {
            $appointment = Appointment::create([
                'business_id' => $businessId,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'employee_id' => $validated['employee_id'],
                'shift' => $validated['shift'],
                'appointment_date' => $validated['appointment_date'],
                'priority' => $validated['priority'],
                'notes' => $validated['notes'],
                'status' => $validated['status'] ?? Appointment::STATUS_PENDING,
                'ticket_number' => Appointment::generateTicketNumber($businessId),
            ]);

            if ($request->has('employee_ids') || $request->has('employee_id')) {
                $employeeIds = $request->filled('employee_ids') ? (array)$request->employee_ids : ($request->filled('employee_id') ? [$request->employee_id] : []);
                if (!empty($employeeIds)) {
                    $appointment->employee_id = $employeeIds[0];
                    $appointment->save();
                    $appointment->employees()->sync($employeeIds);
                }
            }

            $this->appointmentService->syncServicesAndPackages($appointment, $request, true);
            $this->appointmentService->applyAutoPriority($appointment);

            return $appointment;
        });

        return redirect()->route('admin.appointments.index')
            ->with('success', __('Booking created'));
    }

    public function show(Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);
        $appointment->load(['services', 'packages', 'payment', 'employee', 'logs']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);
        $businessId = Auth::user()->business_id;
        $services = Service::forBusiness($businessId)->active()->orderBy('sort_order')->get();
        $packages = Package::where('business_id', $businessId)->active()->with('services')->orderBy('sort_order')->get();
        $employees = User::forBusiness($businessId)->employees()->active()->get();
        $appointment->load(['services', 'packages']);
        return view('admin.appointments.edit', compact('appointment', 'services', 'packages', 'employees'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);

        $request->merge(['customer_phone' => normalizeArabicDigits($request->customer_phone)]);

        $validated = $request->validated();

        DB::transaction(function () use ($appointment, $validated, $request) {
            $oldStatus = $appointment->status;

            $appointment->update([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'employee_id' => $validated['employee_id'],
                'shift' => $validated['shift'],
                'appointment_date' => $validated['appointment_date'],
                'assigned_time' => $validated['assigned_time'] ?? null,
                'priority' => $validated['priority'],
                'notes' => $validated['notes'],
                'status' => $validated['status'],
            ]);

            if ($request->has('employee_ids') || $request->has('employee_id')) {
                $employeeIds = $request->filled('employee_ids') ? (array)$request->employee_ids : ($request->filled('employee_id') ? [$request->employee_id] : []);
                if (!empty($employeeIds)) {
                    $appointment->employee_id = $employeeIds[0];
                    $appointment->save();
                    $appointment->employees()->sync($employeeIds);
                }
            }

            $this->appointmentService->syncServicesAndPackages($appointment, $request, true);
            $this->appointmentService->applyAutoPriority($appointment);

            if ($oldStatus !== $validated['status']) {
                AppointmentLog::create([
                    'appointment_id' => $appointment->id,
                    'action_by' => Auth::id(),
                    'old_status' => $oldStatus,
                    'new_status' => $validated['status'],
                ]);
            }
        });

        return redirect()->route('admin.appointments.show', $appointment)
            ->with('success', __('Booking updated.'));
    }

    public function assignForm(Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);
        $employees = User::where('business_id', Auth::user()->business_id)
            ->where('role', 'employee')
            ->where('is_active', true)
            ->withCount(['assignedAppointments' => fn($q) => $q->whereIn('status', Appointment::ACTIVE_STATUSES)])
            ->get();
        return view('admin.appointments.assign', compact('appointment', 'employees'));
    }

    public function assign(Request $request, Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);

        $request->validate([
            'employee_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(function ($q) {
                    $q->where('business_id', Auth::user()->business_id)
                      ->where('role', 'employee')
                      ->where('is_active', true);
                }),
            ],
            'assigned_time' => 'nullable|date_format:H:i',
        ]);

        DB::transaction(function () use ($appointment, $request) {
            $employeeId = $request->employee_id;

            if (empty($employeeId)) {
                $employees = User::where('business_id', Auth::user()->business_id)
                    ->where('role', 'employee')
                    ->where('is_active', true)
                    ->get();
                $employeeId = $employees->isEmpty() ? null : $employees->random()->id;
            }

            $oldStatus = $appointment->status;
            $appointment->employee_id = $employeeId;
            $appointment->assigned_time = $request->assigned_time;
            $appointment->assigned_by = Auth::id();
            if ($appointment->status === Appointment::STATUS_PENDING) {
                $appointment->status = Appointment::STATUS_ASSIGNED;
            }
            $appointment->save();

            if ($employeeId) {
                $appointment->employees()->sync([$employeeId]);
            }

            AppointmentLog::create([
                'appointment_id' => $appointment->id,
                'action_by' => Auth::id(),
                'old_status' => $oldStatus,
                'new_status' => $appointment->status,
                'notes' => 'Assigned to employee',
            ]);
        });

        return back()->with('success', __('Booking assigned successfully.'));
    }

    /**
     * إلغاء الحجز من الأدمن
     */
    public function cancel(Request $request, Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);

        if (!in_array($appointment->status, Appointment::ACTIVE_STATUSES)) {
            return back()->with('error', __('Cannot cancel this booking'));
        }

        $request->validate(['cancel_reason' => 'nullable|string|max:500']);

        DB::transaction(function () use ($appointment, $request) {
            $oldStatus = $appointment->status;
            $appointment->update([
                'status' => Appointment::STATUS_CANCELLED,
                'cancel_reason' => $request->cancel_reason,
            ]);

            AppointmentLog::create([
                'appointment_id' => $appointment->id,
                'action_by' => Auth::id(),
                'old_status' => $oldStatus,
                'new_status' => Appointment::STATUS_CANCELLED,
                'notes' => 'Booking cancelled',
            ]);
        });

        return redirect()->route('admin.appointments.show', $appointment)
            ->with('success', __('Booking cancelled'));
    }

    /**
     * إعادة حجز — تحويل بيانات الحجز الملغي إلى نموذج إنشاء جديد
     */
    public function rebook(Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);

        if ($appointment->status !== Appointment::STATUS_CANCELLED) {
            return back()->with('error', __('Only cancelled bookings can be rebooked'));
        }

        return redirect()->route('admin.appointments.create')->withInput([
            'customer_name'    => $appointment->customer_name,
            'customer_phone'   => $appointment->customer_phone,
            'package_ids'      => $appointment->packages->pluck('id')->toArray(),
            'service_ids'      => $appointment->services->pluck('id')->toArray(),
            'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
            'shift'            => $appointment->shift,
            'priority'         => $appointment->priority,
            'employee_id'      => $appointment->employee_id,
            'notes'            => $appointment->notes,
        ]);
    }

    /**
     * حذف حجز من النظام
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorizeBusiness($appointment);
        $appointment->delete();
        return redirect()->route('admin.appointments.index')
            ->with('success', __('Booking deleted.'));
    }

}
