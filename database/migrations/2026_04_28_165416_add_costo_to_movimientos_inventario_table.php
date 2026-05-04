<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->decimal('costo_unitario', 12, 2)->nullable()->after('cantidad');
        });
    }

    public function down()
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropColumn('costo_unitario');
        });
    }
};