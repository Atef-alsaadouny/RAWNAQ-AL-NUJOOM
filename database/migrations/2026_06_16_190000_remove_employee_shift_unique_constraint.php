<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropUnique('appointments_employee_date_shift_unique');
            $table->foreign('employee_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->unique(['employee_id', 'appointment_date', 'shift'], 'appointments_employee_date_shift_unique');
            $table->foreign('employee_id')->references('id')->on('users');
        });
    }
};
