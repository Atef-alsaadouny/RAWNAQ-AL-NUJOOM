<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->decimal('total_price', 10, 3)->nullable()->after('package_id');
            $table->string('payment_status')->default('pending')->after('total_price');
            $table->softDeletes();
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending', 'assigned', 'in_progress', 'arrived', 'completed', 'cancelled', 'no_show') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->index('employee_id', 'idx_appointments_employee_id');
            $table->index('customer_id', 'idx_appointments_customer_id');
            $table->index(['status', 'appointment_date'], 'idx_appointments_status_date');
            $table->index(['employee_id', 'appointment_date'], 'idx_appointments_employee_date');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('idx_appointments_employee_date');
            $table->dropIndex('idx_appointments_status_date');
            $table->dropIndex('idx_appointments_customer_id');
            $table->dropIndex('idx_appointments_employee_id');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending', 'assigned', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['total_price', 'payment_status']);
        });
    }
};
