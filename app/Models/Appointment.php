<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';

    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_URGENT = 'urgent';
    const PRIORITY_VIP = 'vip';

    const SHIFT_MORNING = 'morning';
    const SHIFT_EVENING = 'evening';

    const VIP_PRICE_THRESHOLD = 200;
    const VIP_COMPLETED_THRESHOLD = 3;
    const TICKET_PAD_LENGTH = 5;
    const GUEST_TOKEN_LENGTH = 40;
    const MAX_PAGE_SIZE = 20;

    const EDITABLE_STATUSES = ['pending', 'assigned'];
    const ACTIVE_STATUSES = ['pending', 'assigned', 'in_progress'];
    /**
     * الحقول القابلة للتعبئة (المسموح بإدخالها عبر المستخدم)
     * ticket_number: رقم التذكرة (يتم إنشاؤه تلقائياً)
     * business_id: معرف الشركة/الصالون
     * customer_id: معرف العميل
     * employee_id: معرف الموظف
     * service_id: معرف الخدمة
     * shift: الفترة (صباحية/مسائية)
     * appointment_date: تاريخ الموعد
     * assigned_time: الوقت المحدد للموعد
     * status: الحالة (pending, confirmed, completed, cancelled)
     * priority: الأولوية
     * assigned_by: معرف من قام بتعيين الموعد
     * customer_name: اسم العميل (لغير المسجلين)
     * customer_phone: هاتف العميل (لغير المسجلين)
     * notes: ملاحظات إضافية
     * completed_at: تاريخ الإنجاز الفعلي
     */
    protected $fillable = [
        'ticket_number',
        'business_id',
        'customer_id',
        'employee_id',
        'package_id',
        'shift',
        'appointment_date',
        'assigned_time',
        'status',
        'priority',
        'assigned_by',
        'customer_name',
        'customer_phone',
        'notes',
        'cancel_reason',
        'completed_at',
    ];

    /**
     * تحويل أنواع الحقول تلقائياً
     * appointment_date: تاريخ (date) بدون وقت
     * assigned_time: وقت بصيغة H:i (ساعة:دقيقة)
     * completed_at: DateTime كامل
     */
    protected function casts(): array
    {
        return [
            'appointment_date' => 'date:Y-m-d',
            'assigned_time' => 'string',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * العلاقة مع جدول الأعمال - الموعد يخص شركة/صالون معين
     */
    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * العلاقة مع جدول المستخدمين - العميل صاحب الموعد
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * العلاقة مع جدول المستخدمين - الموظف المخصص للموعد (للحجوزات ذات الموظف الواحد)
     */
    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * العلاقة مع الموظفين المتعددين عبر جدول وسيط
     */
    public function employees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'appointment_employee', 'appointment_id', 'employee_id')->withTimestamps();
    }

    /**
     * العلاقة مع جدول الخدمات عبر جدول وسيط - الموعد يمكن أن يحتوي على خدمات متعددة
     */
    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }

    /**
     * العلاقة مع الباقة — إذا كان الموعد عبر باقة
     */
    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * العلاقة مع الباقات المتعددة عبر جدول وسيط
     */
    public function packages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'appointment_package');
    }

    /**
     * العلاقة مع جدول المستخدمين - من قام بتعيين هذا الموعد
     */
    public function assignedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * العلاقة مع جدول التقييمات - التقييم الخاص بهذا الموعد
     */
    public function rating(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Rating::class);
    }

    /**
     * العلاقة مع الدفع — لكل حجز عملية دفع واحدة
     */
    public function payment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * العلاقة مع جدول سجل المواعيد - جميع التغييرات التي طرأت على هذا الموعد
     */
    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AppointmentLog::class);
    }

    /**
     * نطاق (scope) لفلترة المواعيد المعلقة (قيد الانتظار)
     */
    public function scopePending($query): void
    {
        $query->where('status', self::STATUS_PENDING);
    }

    /**
     * نطاق (scope) لفلترة المواعيد الخاصة بشركة/صالون معين
     */
    public function scopeForBusiness($query, $businessId): void
    {
        $query->where('business_id', $businessId);
    }

    /**
     * نطاق (scope) لفلترة المواعيد الخاصة بموظف معين (FK أو pivot)
     */
    public function scopeForEmployee($query, $employeeId): void
    {
        $query->where(function ($q) use ($employeeId) {
            $q->where('appointments.employee_id', $employeeId)
              ->orWhereHas('employees', fn($sq) => $sq->where('appointment_employee.employee_id', $employeeId));
        });
    }

    /**
     * الحصول على أسماء الخدمات كسلسلة نصية (مثلاً: "قص شعر + صبغ")
     * إذا ما في خدمات فردية، يعرض خدمات الباقات
     */
    public function getServiceNamesAttribute()
    {
        $serviceNames = $this->services->pluck('name');

        if ($serviceNames->isNotEmpty()) {
            return $serviceNames->implode(' + ');
        }

        if ($this->packages->isNotEmpty()) {
            return $this->packages->flatMap->services->pluck('name')->unique()->implode(' + ');
        }

        return null;
    }

    public function getDisplayServicesAttribute()
    {
        $names = collect();
        if ($this->relationLoaded('packages')) {
            foreach ($this->packages as $pkg) {
                $names->push($pkg->name);
            }
            $pkgSvcIds = $this->packages->flatMap(fn($p) => $p->relationLoaded('services') ? $p->services->pluck('id') : collect());
        } else {
            $pkgSvcIds = collect();
        }
        if ($this->relationLoaded('services')) {
            foreach ($this->services as $svc) {
                if (!$pkgSvcIds->contains($svc->id)) {
                    $names->push($svc->name);
                }
            }
        }
        return $names->isNotEmpty() ? $names->implode(' + ') : null;
    }

    /**
     * حساب السعر الإجمالي للحجز (مجموع الخدمات + الباقات)
     */
    public function getTotalPriceAttribute()
    {
        $packageServiceIds = collect();
        if ($this->relationLoaded('packages')) {
            foreach ($this->packages as $pkg) {
                $packageServiceIds = $packageServiceIds->merge($pkg->relationLoaded('services') ? $pkg->services->pluck('id') : collect());
            }
        }

        $servicesTotal = 0;
        if ($this->relationLoaded('services')) {
            $servicesTotal = $this->services
                ->reject(fn($svc) => $packageServiceIds->contains($svc->id))
                ->sum('price');
        }

        $packagesTotal = $this->relationLoaded('packages') ? $this->packages->sum('price') : 0;
        return $servicesTotal + $packagesTotal;
    }

    /**
     * هل الحجز مدفوع (non-cash)?
     */
    public function isPaid(): bool
    {
        return $this->payment && $this->payment->isPaid();
    }

    /**
     * هل يمكن تعديل/إلغاء الحجز? (نعم فقط إذا طريقة الدفع كاش)
     */
    public function isEditable(): bool
    {
        return $this->payment && $this->payment->isCash();
    }

    /**
     * حساب الأولوية التلقائية بناءً على السعر الإجمالي أو عدد الحجوزات السابقة
     */
    public function getAutoPriorityAttribute()
    {
        if ($this->total_price >= self::VIP_PRICE_THRESHOLD) {
            return self::PRIORITY_VIP;
        }
        if ($this->previous_completed_count >= self::VIP_COMPLETED_THRESHOLD) {
            return self::PRIORITY_VIP;
        }
        return self::PRIORITY_NORMAL;
    }

    public function getDisplayPriorityAttribute()
    {
        if ($this->auto_priority === self::PRIORITY_VIP) {
            return self::PRIORITY_VIP;
        }
        return $this->priority;
    }

    /**
     * نطاق للحجوزات النشطة (غير المنتهية)
     */
    public function scopeActiveBookings($query): void
    {
        $query->whereIn('status', self::ACTIVE_STATUSES);
    }

    /**
     * إنشاء رقم تذكرة فريد للموعد
     * الصيغة: XXXXX (رقم تسلسلي نظيف)
     */
    public static function generateTicketNumber($businessId)
    {
        $max = static::where('business_id', $businessId)
            ->max('ticket_number');

        $next = $max ? intval($max) + 1 : 1;

        return str_pad($next, self::TICKET_PAD_LENGTH, '0', STR_PAD_LEFT);
    }
}
