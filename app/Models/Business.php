<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    /**
     * الحقول القابلة للتعبئة (المسموح بإدخالها عبر المستخدم)
     * name_ar: اسم الشركة/الصالون بالعربية
     * name_en: اسم الشركة/الصالون بالإنجليزية
     * logo: شعار الشركة
     * phone: رقم الهاتف
     * email: البريد الإلكتروني
     * address: العنوان
     * city: المدينة
     * is_active: حالة التفعيل
     * subscription_plan: خطة الاشتراك
     * trial_ends_at: تاريخ انتهاء الفترة التجريبية
     * settings: إعدادات إضافية (مخزنة بصيغة JSON)
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'logo',
        'phone',
        'email',
        'address',
        'city',
        'is_active',
        'subscription_plan',
        'trial_ends_at',
        'settings',
    ];

    /**
     * تحويل أنواع الحقول تلقائياً
     * is_active: قيمة منطقية (boolean)
     * trial_ends_at: تاريخ (datetime)
     * settings: JSON (يتم تحويله إلى مصفوفة/كائن تلقائياً)
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'trial_ends_at' => 'datetime',
            'settings' => 'json',
        ];
    }

    /**
     * العلاقة مع جدول المستخدمين - جميع المستخدمين التابعين لهذه الشركة
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * العلاقة مع جدول الخدمات - جميع الخدمات التي تقدمها هذه الشركة
     */
    public function services(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * العلاقة مع جدول المواعيد - جميع المواعيد المسجلة في هذه الشركة
     */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * العلاقة مع جدول أوقات العمل - جميع جداول الدوام الخاصة بهذه الشركة
     */
    public function schedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BusinessSchedule::class);
    }

    /**
     * العلاقة مع جدول الباقات - جميع الباقات التي تقدمها هذه الشركة
     */
    public function packages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Package::class);
    }

    /**
     * يعيد جميع الموظفين التابعين للشركة
     */
    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->users()->where('role', 'employee');
    }

    /**
     * يعيد جميع العملاء التابعين للشركة
     */
    public function customers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->users()->where('role', 'customer');
    }

    public function scopeActive($query): void
    {
        $query->where('is_active', true);
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'en' && $this->name_en ? $this->name_en : $this->name_ar;
    }
}
