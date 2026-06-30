<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\AppointmentLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireAppointments extends Command
{
    protected $signature = 'app:expire-appointments';

    protected $description = 'Auto-cancel expired appointments';

    public function handle()
    {
        $expired = Appointment::whereDate('appointment_date', '<', now())
            ->whereIn('status', Appointment::EDITABLE_STATUSES)
            ->get();

        if ($expired->isEmpty()) {
            $this->info('Cancelled 0 expired appointment(s)');
            return;
        }

        $expiredIds = $expired->pluck('id');

        Appointment::whereIn('id', $expiredIds)->update(['employee_id' => null]);

        DB::table('appointment_employee')->whereIn('appointment_id', $expiredIds)->delete();

        $count = 0;
        $logs = [];
        foreach ($expired as $apt) {
            $logs[] = [
                'appointment_id' => $apt->id,
                'old_status' => $apt->status,
                'new_status' => Appointment::STATUS_CANCELLED,
                'notes' => 'Auto-cancelled — appointment expired',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $count++;
        }

        Appointment::whereIn('id', $expiredIds)->update([
            'status' => Appointment::STATUS_CANCELLED,
            'cancel_reason' => 'Appointment expired',
        ]);

        AppointmentLog::insert($logs);

        $this->info("Cancelled {$count} expired appointment(s)");
    }
}
