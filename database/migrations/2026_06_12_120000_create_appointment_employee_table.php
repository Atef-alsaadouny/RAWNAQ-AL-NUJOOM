<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['appointment_id', 'employee_id']);
        });

        $now = DB::getDriverName() === 'sqlite' ? "datetime('now')" : 'now()';
        DB::statement("INSERT INTO appointment_employee (appointment_id, employee_id, created_at, updated_at)
                        SELECT id, employee_id, {$now}, {$now}
                        FROM appointments
                        WHERE employee_id IS NOT NULL");
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_employee');
    }
};
