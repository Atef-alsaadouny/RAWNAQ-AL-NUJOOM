<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class ExpireAppointments extends Command
{
    protected $signature = 'app:expire-appointments';

    protected $description = 'Auto-cancel expired appointments';

    public function handle()
    {
        Appointment::expirePast();

        $this->info('Expired appointments processed.');
    }
}
