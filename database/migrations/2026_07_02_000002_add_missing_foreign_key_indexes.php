<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->index('assigned_by');
            $table->index('package_id');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->index('customer_id');
        });

        Schema::table('appointment_logs', function (Blueprint $table) {
            $table->index('action_by');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['assigned_by']);
            $table->dropIndex(['package_id']);
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIndex(['customer_id']);
        });

        Schema::table('appointment_logs', function (Blueprint $table) {
            $table->dropIndex(['action_by']);
        });
    }
};
