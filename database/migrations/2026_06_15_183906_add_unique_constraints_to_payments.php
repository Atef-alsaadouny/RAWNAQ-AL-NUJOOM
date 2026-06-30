<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::delete('DELETE p1 FROM payments p1 LEFT JOIN (SELECT MIN(id) AS id FROM payments GROUP BY appointment_id) p2 ON p1.id = p2.id WHERE p2.id IS NULL');

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
