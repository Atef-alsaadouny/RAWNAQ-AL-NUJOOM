<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\AuthorizesBusiness;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    use AuthorizesBusiness;
    /**
     * عرض قائمة جميع الموظفين التابعين للشركة
     */
    public function index()
    {
        // الحصول على معرف الشركة وجلب الموظفين مع عدد الحجوزات المسندة لكل منهم
        $businessId = Auth::user()->business_id;
        $employees = User::where('business_id', $businessId)
            ->where('role', 'employee')
            ->withCount(['assignedAppointments'])
            ->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * عرض نموذج إضافة موظف جديد مع قائمة الخدمات المتاحة
     */
    public function create()
    {
        // جلب الخدمات النشطة التابعة للشركة لعرضها في نموذج الاختيار
        $businessId = Auth::user()->business_id;
        $services = Service::where('business_id', $businessId)->where('is_active', true)->get();
        return view('admin.employees.create', compact('services'));
    }

    /**
     * حفظ موظف جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $businessId = Auth::user()->business_id;

        // التحقق من صحة البيانات المدخلة: الاسم، البريد الإلكتروني (اختياري وفريد)، رقم الهاتف، كلمة المرور، والخدمات المحددة
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}a-zA-Z0-9\s\-]+$/u'],
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|digits:8',
            'password' => 'required|string|min:8',
            'services' => 'nullable|array',
            'services.*' => Rule::exists('services', 'id')->where('business_id', $businessId),
        ]);

        // إنشاء معرف الموظف بتنسيق EMP-XXX بناءً على آخر موظف مضاف
        $lastEmployee = User::where('business_id', $businessId)
            ->where('role', 'employee')
            ->orderBy('id', 'desc')
            ->first();

        $nextId = $lastEmployee ? (intval(substr($lastEmployee->employee_id, 4)) + 1) : 1;
        $employeeId = 'EMP-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // إنشاء الموظف الجديد مع تشفير كلمة المرور
        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'employee_id' => $employeeId,
        ]);
        $employee->business_id = $businessId;
        $employee->is_active = true;
        $employee->role = 'employee';
        $employee->save();

        // ربط الخدمات المحددة بالموظف في جدول الوسيط
        if ($request->services) {
            $employee->services()->sync($request->services);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', __('Employee added successfully. Employee ID:') . ' ' . $employeeId);
    }

    /**
     * عرض تفاصيل موظف معين مع حجوزاته وخدماته
     */
    public function show(User $employee)
    {
        // التحقق من أن الموظف ينتمي لنفس شركة المشرف
        $this->authorizeBusiness($employee);
        // جلب الخدمات وآخر 20 حجز للموظف
        $employee->load(['services', 'assignedAppointments' => function ($q) {
            $q->latest()->take(20);
        }]);
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * عرض نموذج تعديل بيانات موظف
     */
    public function edit(User $employee)
    {
        $this->authorizeBusiness($employee);
        $businessId = Auth::user()->business_id;
        // جلب الخدمات النشطة وخدمات الموظف الحالية لعرضها محددة
        $services = Service::where('business_id', $businessId)->where('is_active', true)->get();
        $employee->load('services');
        return view('admin.employees.edit', compact('employee', 'services'));
    }

    /**
     * تحديث بيانات موظف موجود
     */
    public function update(Request $request, User $employee)
    {
        $this->authorizeBusiness($employee);

        // التحقق من صحة البيانات، مع تجاهل البريد الإلكتروني للموظف نفسه في التحقق من uniqueness
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}a-zA-Z0-9\s\-]+$/u'],
            'email' => 'nullable|email|unique:users,email,' . $employee->id,
            'phone' => 'nullable|digits:8',
            'password' => 'nullable|string|min:8',
            'is_active' => 'boolean',
            'services' => 'nullable|array',
            'services.*' => Rule::exists('services', 'id')->where('business_id', Auth::user()->business_id),
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $employee->update($validated);

        // تحديث الخدمات المرتبطة بالموظف
        if ($request->has('services')) {
            $employee->services()->sync($request->services);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', __('Employee data updated successfully.'));
    }

    /**
     * حذف موظف من النظام
     */
    public function destroy(User $employee)
    {
        $this->authorizeBusiness($employee);
        $employee->delete();
        return redirect()->route('admin.employees.index')
            ->with('success', __('Employee deleted successfully.'));
    }

    /**
     * عرض إحصائيات أداء موظف: عدد الحجوزات الكلية، المكتملة، الملغية، ومتوسط التقييم
     */
    public function performance(User $employee)
    {
        $this->authorizeBusiness($employee);

        $businessId = Auth::user()->business_id;

        $appointments = Appointment::forEmployee($employee->id)
            ->where('appointments.business_id', $businessId)
            ->get();
        $ratings = Rating::where('employee_id', $employee->id)
            ->whereIn('appointment_id', Appointment::forBusiness($businessId)->pluck('id'));

        // حساب الإحصائيات
        $stats = [
            'total_appointments' => $appointments->count(),
            'completed' => $appointments->where('status', Appointment::STATUS_COMPLETED)->count(),
            'cancelled' => $appointments->where('status', Appointment::STATUS_CANCELLED)->count(),
            'avg_rating' => $ratings->avg('rating') ?? 0,
            'total_ratings' => $ratings->count(),
        ];

        return view('admin.employees.performance', compact('employee', 'stats'));
    }

}
