<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analisis_precios_unitarios', function (Blueprint $table) {
            $table->id();
            
            // Datos principales
            $table->string('codigo', 50)->unique()->comment('Código único del APU (ej: MAT-001, MOB-001)');
            $table->string('concepto', 500)->comment('Descripción del concepto');
            $table->enum('categoria', ['materiales', 'mano_obra', 'maquinaria', 'subcontratos', 'indirectos'])
                ->default('materiales')
                ->comment('Categoría del análisis');
            $table->string('unidad', 20)->comment('Unidad de medida (m³, kg, jor, hr, m², %)');
            
            // Costos por componente
            $table->decimal('costo_materiales', 15, 2)->default(0)->comment('Costo de materiales por unidad');
            $table->decimal('costo_mano_obra', 15, 2)->default(0)->comment('Costo de mano de obra por unidad');
            $table->decimal('costo_maquinaria', 15, 2)->default(0)->comment('Costo de maquinaria por unidad');
            $table->decimal('costo_subcontratos', 15, 2)->default(0)->comment('Costo de subcontratos por unidad');
            $table->decimal('costo_total', 15, 2)->default(0)->comment('Suma de todos los costos (calculado)');
            
            // Estado y control
            $table->enum('estado', ['activo', 'revision', 'inactivo'])->default('activo')->comment('Estado del APU');
            $table->text('observaciones')->nullable()->comment('Notas adicionales');
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que creó');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimización
            $table->index('codigo');
            $table->index('categoria');
            $table->index('estado');
            $table->index(['categoria', 'estado'], 'idx_categoria_estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analisis_precios_unitarios');
    }
};