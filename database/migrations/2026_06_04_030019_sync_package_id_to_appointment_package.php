<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('appointments')
            ->whereNotNull('package_id')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('appointment_package')
                    ->whereColumn('appointment_package.appointment_id', 'appointments.id')
                    ->whereColumn('appointment_package.package_id', 'appointments.package_id');
            })
            ->orderBy('id')
            ->each(function ($appointment) {
                DB::table('appointment_package')->insert([
                    'appointment_id' => $appointment->id,
                    'package_id' => $appointment->package_id,
                ]);
            });
    }

    public function down(): void
    {
        // لا يمكن التراجع — مجرد إضافة بيانات
    }
};
