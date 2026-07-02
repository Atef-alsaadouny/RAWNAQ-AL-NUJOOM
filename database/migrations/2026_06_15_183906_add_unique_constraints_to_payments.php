<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::delete('DELETE FROM payments WHERE id NOT IN (SELECT MIN(id) FROM payments GROUP BY appointment_id)');

        Schema::table('payments', function (Blueprint $table) {
            $table->unique('appointment_id', 'payments_appointment_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique('payments_appointment_id_unique');
        });
    }
};
