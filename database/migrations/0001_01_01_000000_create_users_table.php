<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // إنشاء جدول المستخدمين
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للمستخدم
            $table->string('name'); // اسم المستخدم
            $table->string('email')->unique(); // البريد الإلكتروني (فريد)
            $table->timestamp('email_verified_at')->nullable(); // تاريخ التحقق من البريد الإلكتروني
            $table->string('password'); // كلمة المرور (مشفرة)
            $table->rememberToken(); // توكن تذكرني لتسجيل الدخول التلقائي
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });

        // إنشاء جدول توكنات إعادة تعيين كلمة المرور
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // البريد الإلكتروني (مفتاح رئيسي)
            $table->string('token'); // توكن إعادة التعيين
            $table->timestamp('created_at')->nullable(); // تاريخ إنشاء التوكن
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
