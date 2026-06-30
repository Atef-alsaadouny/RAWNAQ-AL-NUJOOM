<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول سجل تغييرات المواعيد
        Schema::create('appointment_logs', function (Blueprint $table) {
            $table->id(); // المعرف الفريد لسجل التغيير
            // المفتاح الخارجي للموعد — يشير إلى جدول appointments
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete(); // عند حذف الموعد يُحذف سجله
            // المفتاح الخارجي للمستخدم الذي قام بالإجراء — يشير إلى جدول users
            $table->foreignId('action_by')->constrained('users')->cascadeOnDelete(); // عند حذف المستخدم تُحذف سجلاته
            $table->string('old_status')->nullable(); // الحالة السابقة للموعد
            $table->string('new_status'); // الحالة الجديدة للموعد
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_logs');
    }
};
