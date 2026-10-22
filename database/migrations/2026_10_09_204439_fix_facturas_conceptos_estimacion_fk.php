<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Eliminar la columna redundante proyecto_partida_id
        //    (partida_id ya existe y apunta a proyecto_partidas)
        if (Schema::hasColumn('facturas_conceptos', 'proyecto_partida_id')) {
            Schema::table('facturas_conceptos', function (Blueprint $table) {
                $table->dropColumn('proyecto_partida_id');
            });
        }

        // 2) Agregar FK real para estimacion_id → estimaciones_partidas
        //    Solo si no existe ya
        $fks = collect(Schema::getForeignKeys('facturas_conceptos'))
            ->pluck('name')
            ->toArray();

        if (!in_array('facturas_conceptos_estimacion_id_foreign', $fks)) {
            Schema::table('facturas_conceptos', function (Blueprint $table) {
                $table->foreign('estimacion_id')
                      ->references('id')
                      ->on('estimaciones_partidas')
                      ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('facturas_conceptos', function (Blueprint $table) {
            $table->dropForeign(['estimacion_id']);
            $table->unsignedBigInteger('proyecto_partida_id')->nullable()->after('estimacion_id');
        });
    }
};