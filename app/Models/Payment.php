<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_UNPAID = 'unpaid';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    const METHOD_CASH = 'cash';
    const METHOD_KNET = 'knet';
    const METHOD_APPLE_PAY = 'apple_pay';
    const METHOD_GOOGLE_PAY = 'google_pay';

    protected $fillable = [
        'appointment_id',
        'method',
        'amount',
        'status',
        'transaction_id',
        'tap_charge_id',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'amount' => 'decimal:3',
        ];
    }

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isCash(): bool
    {
        return $this->method === self::METHOD_CASH;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    public static function tapIsConfigured(): bool
    {
        return !empty(config('services.tap.secret_key'))
            && !empty(config('services.tap.public_key'));
    }

    public static function availableMethods(): array
    {
        return [
            self::METHOD_KNET,
            self::METHOD_APPLE_PAY,
            self::METHOD_GOOGLE_PAY,
            self::METHOD_CASH,
        ];
    }

    public function isKnet(): bool
    {
        return $this->method === self::METHOD_KNET;
    }

    public function isApplePay(): bool
    {
        return $this->method === self::METHOD_APPLE_PAY;
    }

    public function isGooglePay(): bool
    {
        return $this->method === self::METHOD_GOOGLE_PAY;
    }

    public function scopePaid($query): void
    {
        $query->where('status', self::STATUS_PAID);
    }

    public function scopeUnpaid($query): void
    {
        $query->where('status', self::STATUS_UNPAID);
    }

    public function scopeFailed($query): void
    {
        $query->where('status', self::STATUS_FAILED);
    }

    public function scopeRefunded($query): void
    {
        $query->where('status', self::STATUS_REFUNDED);
    }
}
