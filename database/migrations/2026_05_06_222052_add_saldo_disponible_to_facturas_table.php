<?php
// database/migrations/2026_05_06_000004_add_saldo_disponible_to_facturas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (!Schema::hasColumn('facturas', 'saldo_disponible')) {
                $table->decimal('saldo_disponible', 12, 2)->default(0)->after('total');
            }
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('saldo_disponible');
        });
    }
};