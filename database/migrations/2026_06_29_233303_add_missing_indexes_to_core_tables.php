<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('business_id', 'idx_users_business_id');
            $table->index(['business_id', 'role'], 'idx_users_business_role');
            $table->index('phone', 'idx_users_phone');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index('business_id', 'idx_services_business_id');
            $table->index(['business_id', 'is_active', 'sort_order'], 'idx_services_business_active_sort');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->index('business_id', 'idx_packages_business_id');
            $table->index(['business_id', 'is_active', 'sort_order'], 'idx_packages_business_active_sort');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->index('business_id', 'idx_appointments_business_id');
            $table->index(['business_id', 'appointment_date'], 'idx_appointments_business_date');
            $table->index(['business_id', 'status'], 'idx_appointments_business_status');
            $table->index('customer_phone', 'idx_appointments_customer_phone');
            $table->index('created_at', 'idx_appointments_created_at');
        });

        Schema::table('appointment_employee', function (Blueprint $table) {
            $table->index('employee_id', 'idx_appointment_employee_employee_id');
        });

        Schema::table('appointment_logs', function (Blueprint $table) {
            $table->index('appointment_id', 'idx_appointment_logs_appointment_id');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->index('employee_id', 'idx_ratings_employee_id');
        });

        Schema::table('employee_service', function (Blueprint $table) {
            $table->index('service_id', 'idx_employee_service_service_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_business_id');
            $table->dropIndex('idx_users_business_role');
            $table->dropIndex('idx_users_phone');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('idx_services_business_id');
            $table->dropIndex('idx_services_business_active_sort');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropIndex('idx_packages_business_id');
            $table->dropIndex('idx_packages_business_active_sort');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('idx_appointments_business_id');
            $table->dropIndex('idx_appointments_business_date');
            $table->dropIndex('idx_appointments_business_status');
            $table->dropIndex('idx_appointments_customer_phone');
            $table->dropIndex('idx_appointments_created_at');
        });

        Schema::table('appointment_employee', function (Blueprint $table) {
            $table->dropIndex('idx_appointment_employee_employee_id');
        });

        Schema::table('appointment_logs', function (Blueprint $table) {
            $table->dropIndex('idx_appointment_logs_appointment_id');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIndex('idx_ratings_employee_id');
        });

        Schema::table('employee_service', function (Blueprint $table) {
            $table->dropIndex('idx_employee_service_service_id');
        });
    }
};
