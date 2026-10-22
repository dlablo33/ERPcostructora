<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas_conceptos', function (Blueprint $table) {
            $table->foreign('estimacion_id')
                  ->references('id')
                  ->on('estimaciones_partidas')
                  ->nullOnDelete();

            $table->foreign('proyecto_partida_id')
                  ->references('id')
                  ->on('proyecto_partidas')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('facturas_conceptos', function (Blueprint $table) {
            $table->dropForeign(['estimacion_id']);
            $table->dropForeign(['proyecto_partida_id']);
        });
    }
};