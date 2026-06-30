<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->enum('method', ['knet', 'apple_pay', 'google_pay', 'cash']);
            $table->decimal('amount', 8, 3);
            $table->enum('status', ['unpaid', 'paid', 'failed', 'refunded'])->default('unpaid');
            $table->string('transaction_id')->nullable();
            $table->string('tap_charge_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
