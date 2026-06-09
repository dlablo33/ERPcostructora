<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_conceptos', function (Blueprint $table) {
            $table->id();
            $table->string('categoria', 50); // costos_variables, gastos_fijos, financiamiento, mantenimiento
            $table->string('codigo_sat', 20); // código SAT asociado (ej: 531, 532, 511.02)
            $table->string('nombre_concepto', 150);
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
            
            // Índices para búsqueda rápida
            $table->index('categoria');
            $table->index('codigo_sat');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_conceptos');
    }
};