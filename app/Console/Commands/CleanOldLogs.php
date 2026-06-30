<?php

namespace App\Console\Commands;

use App\Models\AppointmentLog;
use Illuminate\Console\Command;

class CleanOldLogs extends Command
{
    protected $signature = 'app:clean-old-logs';

    protected $description = 'حذف سجلات التعديل الأقدم من ٦ شهور';

    public function handle()
    {
        $cutoff = now()->subMonths(6);
        $deleted = AppointmentLog::where('created_at', '<', $cutoff)->delete();
        $this->info("تم حذف {$deleted} سجل قديم");
    }
}