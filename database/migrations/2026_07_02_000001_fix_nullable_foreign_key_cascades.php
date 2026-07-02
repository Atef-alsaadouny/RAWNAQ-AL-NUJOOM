<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->foreign('employee_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('appointment_logs', function (Blueprint $table) {
            $table->dropForeign(['action_by']);
            $table->foreign('action_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->foreign('employee_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('appointment_logs', function (Blueprint $table) {
            $table->dropForeign(['action_by']);
            $table->foreign('action_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
