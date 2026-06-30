<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'action_by',
        'old_status',
        'new_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [];
    }

    /**
     * العلاقة مع جدول المواعيد - السجل يخص موعد معين
     */
    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * العلاقة مع جدول المستخدمين - المستخدم الذي قام بالإجراء
     */
    public function actionBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
