<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول المواعيد
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للموعد
            $table->string('ticket_number')->unique(); // رقم التذكرة الفريد لكل موعد
            // المفتاح الخارجي للنشاط التجاري — يشير إلى جدول businesses
            $table->foreignId('business_id')->constrained()->cascadeOnDelete(); // عند حذف النشاط تُحذف مواعيده
            // المفتاح الخارجي للعميل — يشير إلى جدول users
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete(); // عند حذف العميل يبقى الموعد بقيمة فارغة
            // المفتاح الخارجي للموظف — يشير إلى جدول users
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete(); // عند حذف الموظف يبقى الموعد بقيمة فارغة
            // المفتاح الخارجي للخدمة — يشير إلى جدول services
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete(); // عند حذف الخدمة يبقى الموعد بقيمة فارغة
            $table->enum('shift', ['morning', 'evening']); // الفترة: صباحية أو مسائية
            $table->date('appointment_date'); // تاريخ الموعد
            $table->time('assigned_time')->nullable(); // الوقت المحدد للموعد (عند التعيين)
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending'); // حالة الموعد
            $table->enum('priority', ['normal', 'urgent', 'vip'])->default('normal'); // أولوية الموعد
            // المفتاح الخارجي لمن قام بتعيين الموعد — يشير إلى جدول users (عادةً الأدمن)
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_name')->nullable(); // اسم العميل (للحجز السريع بدون حساب)
            $table->string('customer_phone')->nullable(); // هاتف العميل (للحجز السريع)
            $table->text('notes')->nullable(); // ملاحظات إضافية على الموعد
            $table->timestamp('completed_at')->nullable(); // تاريخ إتمام الموعد
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
