<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * الحقول القابلة للتعبئة (المسموح بإدخالها عبر المستخدم)
     * name: اسم المستخدم
     * email: البريد الإلكتروني
     * password: كلمة المرور (سيتم تشفيرها)
     * role: صلاحية المستخدم (admin, employee, customer)
     * employee_id: رقم الموظف الداخلي
     * phone: رقم الهاتف
     * business_id: معرف الشركة/الصالون التابع له
     * is_active: حالة التفعيل (نشط/غير نشط)
     * last_login_at: تاريخ آخر تسجيل دخول
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'phone',
        'last_login_at',
        'business_id',
        'role',
        'is_active',
    ];

    /**
     * الحقول المخفية عند تحويل النموذج إلى JSON أو مصفوفة
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويل أنواع الحقول تلقائياً
     * email_verified_at: يحول إلى DateTime
     * password: يحول إلى قيمة مشفرة (hashed)
     * is_active: يحول إلى قيمة منطقية (boolean)
     * last_login_at: يحول إلى DateTime
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * العلاقة مع جدول الأعمال - المستخدم التابع لشركة/صالون معين
     */
    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * العلاقة مع جدول المواعيد - المواعيد التي حجزها هذا العميل
     */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class, 'customer_id');
    }

    /**
     * العلاقة مع جدول المواعيد - المواعيد المخصصة لهذا الموظف
     */
    public function assignedAppointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class, 'employee_id');
    }

    /**
     * العلاقة مع جدول المواعيد - المواعيد التي تم تعيينها بواسطة هذا المستخدم
     */
    public function assignedTickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class, 'assigned_by');
    }

    /**
     * العلاقة مع جدول الخدمات عبر جدول وسيط - الخدمات التي يقدمها هذا الموظف
     * pivot: يحتوي على السعر المعدل (price_override)
     */
    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'employee_service', 'employee_id', 'service_id')
            ->withPivot('price_override')
            ->withTimestamps();
    }

    /**
     * العلاقة مع جدول التقييمات - التقييمات التي حصل عليها هذا الموظف
     */
    public function ratings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rating::class, 'employee_id');
    }

    /**
     * العلاقة مع جدول سجل المواعيد - الإجراءات التي قام بها هذا المستخدم
     */
    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AppointmentLog::class, 'action_by');
    }

    /**
     * التحقق مما إذا كان المستخدم مديراً (admin)
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * التحقق مما إذا كان المستخدم موظفاً (employee)
     */
    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    /**
     * التحقق مما إذا كان المستخدم عميلاً (customer)
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * التحقق مما إذا كان المستخدم مالكاً (owner)
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function scopeActive($query): void
    {
        $query->where('is_active', true);
    }

    public function scopeEmployees($query): void
    {
        $query->where('role', 'employee');
    }

    public function scopeForBusiness($query, $businessId): void
    {
        $query->where('business_id', $businessId);
    }
}
