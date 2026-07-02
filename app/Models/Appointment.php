<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 'pending';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';
    const STATUS_ARRIVED = 'arrived';
    const STATUS_NO_SHOW = 'no_show';

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
    const ACTIVE_STATUSES = ['pending', 'assigned', 'in_progress', 'arrived'];

    protected $fillable = [
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
        'total_price',
        'payment_status',
        'ticket_number',
        'guest_token',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date:Y-m-d',
            'assigned_time' => 'string',
            'completed_at' => 'datetime',
            'deleted_at' => 'datetime',
            'total_price' => 'decimal:3',
            'payment_status' => 'string',
        ];
    }

    private static bool $alreadyExpired = false;

    public static function expirePast(): void
    {
        if (self::$alreadyExpired) {
            return;
        }
        self::$alreadyExpired = true;

        $expired = static::whereDate('appointment_date', '<', now()->toDateString())
            ->whereIn('status', self::EDITABLE_STATUSES)
            ->get();

        if ($expired->isEmpty()) {
            return;
        }

        $expiredIds = $expired->pluck('id');

        static::whereIn('id', $expiredIds)->update(['employee_id' => null]);

        DB::table('appointment_employee')->whereIn('appointment_id', $expiredIds)->delete();

        $logs = [];
        foreach ($expired as $apt) {
            $logs[] = [
                'appointment_id' => $apt->id,
                'old_status' => $apt->status,
                'new_status' => self::STATUS_CANCELLED,
                'notes' => 'Auto-cancelled — appointment expired',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        static::whereIn('id', $expiredIds)->update([
            'status' => self::STATUS_CANCELLED,
            'cancel_reason' => 'Appointment expired',
        ]);

        \App\Models\AppointmentLog::insert($logs);
    }

    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function employees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'appointment_employee', 'appointment_id', 'employee_id')->withTimestamps();
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function packages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'appointment_package');
    }

    public function assignedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function rating(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Rating::class);
    }

    public function payment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AppointmentLog::class);
    }

    public function scopePending($query): void
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function scopeForBusiness($query, $businessId): void
    {
        $query->where('business_id', $businessId);
    }

    public function scopeForEmployee($query, $employeeId): void
    {
        $query->where(function ($q) use ($employeeId) {
            $q->where('appointments.employee_id', $employeeId)
              ->orWhereHas('employees', fn($sq) => $sq->where('appointment_employee.employee_id', $employeeId));
        });
    }

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

    public function isPaid(): bool
    {
        return $this->payment && $this->payment->isPaid();
    }

    public function isEditable(): bool
    {
        return $this->payment && $this->payment->isCash();
    }

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

    public function scopeActiveBookings($query): void
    {
        $query->whereIn('status', self::ACTIVE_STATUSES);
    }

    public static function generateTicketNumber($businessId)
    {
        $max = static::where('business_id', $businessId)
            ->max('ticket_number');

        $next = $max ? intval($max) + 1 : 1;

        return str_pad($next, self::TICKET_PAD_LENGTH, '0', STR_PAD_LEFT);
    }
}
