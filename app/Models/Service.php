<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasLocalizedAttributes;
    /**
     * الحقول القابلة للتعبئة (المسموح بإدخالها عبر المستخدم)
     * business_id: معرف الشركة/الصالون
     * name_ar: اسم الخدمة بالعربية
     * name_en: اسم الخدمة بالإنجليزية
     * description_ar: وصف الخدمة بالعربية
     * description_en: وصف الخدمة بالإنجليزية
     * price: السعر
     * duration_minutes: المدة بالدقائق
     * is_active: حالة التفعيل
     * sort_order: ترتيب العرض
     */
    protected $fillable = [
        'business_id',
        'name_ar',
        'name_en',
        'category',
        'description_ar',
        'description_en',
        'price',
        'duration_minutes',
        'is_active',
        'sort_order',
    ];

    /**
     * تحويل أنواع الحقول تلقائياً
     * price: رقم عشري بثلاث خانات (decimal:3)
     * is_active: قيمة منطقية (boolean)
     * sort_order: رقم صحيح (integer)
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:3',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'duration_minutes' => 'integer',
        ];
    }

    /**
     * العلاقة مع جدول الأعمال - الخدمة تابعة لشركة/صالون معين
     */
    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * العلاقة مع جدول المواعيد عبر جدول وسيط - المواعيد التي تستخدم هذه الخدمة
     */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Appointment::class)->withTimestamps();
    }

    /**
     * العلاقة مع جدول المستخدمين عبر جدول وسيط - الموظفون الذين يقدمون هذه الخدمة
     * pivot: يحتوي على السعر المعدل (price_override)
     */
    public function employees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employee_service', 'service_id', 'employee_id')
            ->withPivot('price_override')
            ->withTimestamps();
    }

    /**
     * العلاقة مع الباقات — الخدمة يمكن أن تكون ضمن عدة باقات
     */
    public function packages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }

    public function scopeActive($query): void
    {
        $query->where('is_active', true);
    }

    public function scopeForBusiness($query, $businessId): void
    {
        $query->where('business_id', $businessId);
    }
}
