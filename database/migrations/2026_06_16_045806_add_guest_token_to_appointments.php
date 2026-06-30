<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('guest_token', 40)->nullable()->after('ticket_number');
            $table->index('guest_token', 'appointments_guest_token_index');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('appointments_guest_token_index');
            $table->dropColumn('guest_token');
        });
    }
};
