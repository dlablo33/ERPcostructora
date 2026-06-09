<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activos', function (Blueprint $table) {
            // Agregar columna unidad_negocio_id
            $table->unsignedBigInteger('unidad_negocio_id')->nullable()->after('estatus');
            
            // Agregar llave foránea
            $table->foreign('unidad_negocio_id', 'fk_activos_unidad_negocio')
                  ->references('cat_unidad_negocio_id')
                  ->on('cat_unidades_negocio')
                  ->onDelete('set null');
            
            // Agregar índice
            $table->index('unidad_negocio_id', 'idx_activos_unidad_negocio');
        });
    }

    public function down(): void
    {
        Schema::table('activos', function (Blueprint $table) {
            // Eliminar índice
            $table->dropIndex('idx_activos_unidad_negocio');
            
            // Eliminar llave foránea
            $table->dropForeign('fk_activos_unidad_negocio');
            
            // Eliminar columna
            $table->dropColumn('unidad_negocio_id');
        });
    }
};