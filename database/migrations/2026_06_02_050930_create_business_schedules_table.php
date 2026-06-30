<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول أوقات العمل للنشاط التجاري
        Schema::create('business_schedules', function (Blueprint $table) {
            $table->id(); // المعرف الفريد لجدول الوقت
            // المفتاح الخارجي للنشاط التجاري — يشير إلى جدول businesses
            $table->foreignId('business_id')->constrained()->cascadeOnDelete(); // عند حذف النشاط تُحذف أوقات عمله
            $table->tinyInteger('day_of_week'); // رقم اليوم في الأسبوع (0=Sunday, 1=Monday, ...)
            $table->enum('shift', ['morning', 'evening']); // الفترة: صباحية أو مسائية
            $table->time('start_time'); // وقت البداية
            $table->time('end_time'); // وقت النهاية
            $table->boolean('is_active')->default(true); // هل هذا الجدول نشط؟
            $table->timestamps(); // تاريخ الإنشاء والتحديث
            $table->unique(['business_id', 'day_of_week', 'shift']); // ضمان عدم تكرار نفس اليوم والفترة لنفس النشاط
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_schedules');
    }
};
