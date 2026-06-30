<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الخدمات المقدمة من النشاط التجاري
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للخدمة
            // المفتاح الخارجي للنشاط التجاري — يشير إلى جدول businesses
            $table->foreignId('business_id')->constrained()->cascadeOnDelete(); // عند حذف النشاط تُحذف خدماته
            $table->string('name_ar'); // اسم الخدمة بالعربية
            $table->string('name_en')->nullable(); // اسم الخدمة بالإنجليزية
            $table->text('description_ar')->nullable(); // وصف الخدمة بالعربية
            $table->text('description_en')->nullable(); // وصف الخدمة بالإنجليزية
            $table->decimal('price', 8, 3)->default(0); // سعر الخدمة
            $table->integer('duration_minutes')->default(30); // مدة الخدمة بالدقائق
            $table->boolean('is_active')->default(true); // هل الخدمة متاحة؟
            $table->integer('sort_order')->default(0); // ترتيب عرض الخدمة
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
