<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::delete('DELETE FROM appointments WHERE id NOT IN (
            SELECT MIN(id) FROM appointments
            WHERE employee_id IS NOT NULL
            AND status IN ("pending","assigned","in_progress")
            GROUP BY employee_id, appointment_date, shift
        ) AND employee_id IS NOT NULL
        AND status IN ("pending","assigned","in_progress")');

        Schema::table('appointments', function (Blueprint $table) {
            $table->unique(['employee_id', 'appointment_date', 'shift'], 'appointments_employee_date_shift_unique');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropUnique('appointments_employee_date_shift_unique');
        });
    }
};
