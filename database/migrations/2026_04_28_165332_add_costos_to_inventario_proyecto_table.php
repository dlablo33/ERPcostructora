<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventario_proyecto', function (Blueprint $table) {
            $table->decimal('costo_promedio', 12, 2)->nullable()->after('punto_reorden');
            $table->decimal('ultimo_costo', 12, 2)->nullable()->after('costo_promedio');
            $table->decimal('ultimo_costo_compra', 12, 2)->nullable()->after('ultimo_costo');
        });
    }

    public function down()
    {
        Schema::table('inventario_proyecto', function (Blueprint $table) {
            $table->dropColumn(['costo_promedio', 'ultimo_costo', 'ultimo_costo_compra']);
        });
    }
};