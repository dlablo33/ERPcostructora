<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_unidad_conceptos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidad_negocio_id');
            $table->unsignedBigInteger('concepto_id');
            $table->decimal('porcentaje', 10, 2)->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            // Llaves foráneas
            $table->foreign('unidad_negocio_id', 'fk_unidad_conceptos_unidad')
                  ->references('cat_unidad_negocio_id')
                  ->on('cat_unidades_negocio')
                  ->onDelete('cascade');
            
            $table->foreign('concepto_id', 'fk_unidad_conceptos_concepto')
                  ->references('id')
                  ->on('config_conceptos')
                  ->onDelete('cascade');
            
            // Índices
            $table->index('unidad_negocio_id');
            $table->index('concepto_id');
            
            // Evitar duplicados (una combinación única por unidad y concepto)
            $table->unique(['unidad_negocio_id', 'concepto_id'], 'unique_unidad_concepto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_unidad_conceptos');
    }
};