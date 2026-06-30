<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSchedule extends Model
{
    use HasFactory;
    /**
     * الحقول القابلة للتعبئة (المسموح بإدخالها عبر المستخدم)
     * business_id: معرف الشركة/الصالون
     * day_of_week: اليوم في الأسبوع (0=الأحد, 1=الإثنين, ...)
     * shift: الفترة (صباحية/مسائية)
     * start_time: وقت بداية الدوام
     * end_time: وقت نهاية الدوام
     * is_active: حالة التفعيل (هل هذا الجدول نشط)
     */
    protected $fillable = [
        'business_id',
        'day_of_week',
        'shift',
        'start_time',
        'end_time',
        'is_active',
    ];

    /**
     * تحويل أنواع الحقول تلقائياً
     * is_active: قيمة منطقية (boolean)
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * العلاقة مع جدول الأعمال - جدول الدوام يخص شركة/صالون معين
     */
    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
