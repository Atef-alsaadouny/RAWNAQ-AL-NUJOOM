<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الربط بين الموظفين والخدمات (علاقة كثير إلى كثير)
        Schema::create('employee_service', function (Blueprint $table) {
            $table->id(); // المعرف الفريد لسجل الربط
            // المفتاح الخارجي للموظف — يشير إلى جدول users (معرف الموظف)
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete(); // عند حذف الموظف يُحذف الربط
            // المفتاح الخارجي للخدمة — يشير إلى جدول services
            $table->foreignId('service_id')->constrained()->cascadeOnDelete(); // عند حذف الخدمة يُحذف الربط
            $table->decimal('price_override', 8, 3)->nullable(); // سعر مخصص لهذا الموظف لهذه الخدمة (تجاوز السعر الافتراضي)
            $table->timestamps(); // تاريخ الإنشاء والتحديث
            $table->unique(['employee_id', 'service_id']); // ضمان عدم تكرار نفس الخدمة لنفس الموظف
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_service');
    }
};
