<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas_conceptos', function (Blueprint $table) {
            // Relación con la estimación que se está facturando
            $table->unsignedBigInteger('estimacion_id')
                  ->nullable()
                  ->after('factura_id');
            
            // Relación con la partida del proyecto (para reportes rápidos)
            $table->unsignedBigInteger('proyecto_partida_id')
                  ->nullable()
                  ->after('estimacion_id');
            
            $table->index('estimacion_id');
            $table->index('proyecto_partida_id');
        });
    }

    public function down(): void
    {
        Schema::table('facturas_conceptos', function (Blueprint $table) {
            $table->dropIndex(['estimacion_id']);
            $table->dropIndex(['proyecto_partida_id']);
            $table->dropColumn(['estimacion_id', 'proyecto_partida_id']);
        });
    }
};