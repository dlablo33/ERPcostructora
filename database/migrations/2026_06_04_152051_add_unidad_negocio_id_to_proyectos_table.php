<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // Agregar la columna
            $table->unsignedBigInteger('unidad_negocio_id')->nullable()->after('status');
            
            // Agregar la llave foránea
            $table->foreign('unidad_negocio_id', 'fk_proyectos_unidad_negocio')
                  ->references('cat_unidad_negocio_id')
                  ->on('cat_unidades_negocio')
                  ->onDelete('set null'); // Cuando se elimine una unidad, los proyectos quedan con NULL
            
            // Agregar índice para mejorar rendimiento
            $table->index('unidad_negocio_id', 'idx_proyectos_unidad_negocio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // Eliminar el índice
            $table->dropIndex('idx_proyectos_unidad_negocio');
            
            // Eliminar la llave foránea
            $table->dropForeign('fk_proyectos_unidad_negocio');
            
            // Eliminar la columna
            $table->dropColumn('unidad_negocio_id');
        });
    }
};