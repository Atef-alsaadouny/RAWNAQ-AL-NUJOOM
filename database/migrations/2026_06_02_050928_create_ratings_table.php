<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول التقييمات
        Schema::create('ratings', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للتقييم
            // المفتاح الخارجي للموعد — يشير إلى جدول appointments (كل موعد له تقييم واحد فقط)
            $table->foreignId('appointment_id')->unique()->constrained()->cascadeOnDelete(); // عند حذف الموعد يُحذف تقييمه
            // المفتاح الخارجي للعميل — يشير إلى جدول users
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete(); // عند حذف العميل يبقى التقييم بقيمة فارغة
            // المفتاح الخارجي للموظف — يشير إلى جدول users (الموظف الذي قام بالخدمة)
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete(); // عند حذف الموظف تُحذف تقييماته
            $table->tinyInteger('rating')->unsigned(); // التقييم (1-5)
            $table->text('comment')->nullable(); // تعليق العميل على التقييم
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
