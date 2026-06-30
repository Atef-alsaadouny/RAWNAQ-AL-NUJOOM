<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // تعديل جدول المستخدمين — إضافة أعمدة الدور والتابعية للنشاط التجاري
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('email'); // دور المستخدم: admin, employee, customer
            $table->string('employee_id')->nullable()->after('role'); // معرف الموظف الداخلي (مثل EMP-001)
            $table->string('phone')->nullable()->after('employee_id'); // رقم هاتف المستخدم
            // المفتاح الخارجي للنشاط التجاري — يشير إلى جدول businesses
            $table->foreignId('business_id')->nullable()->constrained()->nullOnDelete()->after('phone');
            $table->boolean('is_active')->default(true)->after('business_id'); // هل الحساب نشط؟
            $table->timestamp('last_login_at')->nullable()->after('is_active'); // تاريخ آخر تسجيل دخول
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'employee_id', 'phone', 'business_id', 'is_active', 'last_login_at']);
        });
    }
};
