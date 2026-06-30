<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الأنشطة التجارية (صالونات / محلات)
        Schema::create('businesses', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للنشاط التجاري
            $table->string('name_ar'); // اسم النشاط التجاري بالعربية
            $table->string('name_en')->nullable(); // اسم النشاط التجاري بالإنجليزية
            $table->string('logo')->nullable(); // رابط شعار النشاط التجاري
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->string('email')->nullable(); // البريد الإلكتروني
            $table->string('address')->nullable(); // العنوان
            $table->string('city')->nullable(); // المدينة
            $table->boolean('is_active')->default(true); // هل النشاط التجاري نشط؟
            $table->string('subscription_plan')->default('trial'); // خطة الاشتراك (trial, monthly, yearly)
            $table->timestamp('trial_ends_at')->nullable(); // تاريخ انتهاء الفترة التجريبية
            $table->json('settings')->nullable(); // إعدادات إضافية بصيغة JSON
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
