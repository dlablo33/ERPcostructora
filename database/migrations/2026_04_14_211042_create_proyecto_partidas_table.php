<?php
// database/migrations/2026_04_14_000001_create_proyecto_partidas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyecto_partidas', function (Blueprint $table) {
            $table->id();
            
            // Relación con proyecto
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade');
            
            // Datos de la partida
            $table->string('codigo', 50);                    // Ej: CIM-001, EST-002
            $table->string('nombre', 255);                   // Nombre de la partida
            $table->text('descripcion')->nullable();         // Descripción detallada
            
            // Clasificación
            $table->string('seccion', 100)->nullable();      // Cimentación, Estructura, Acabados, etc.
            $table->enum('categoria', [
                'materiales', 
                'mano_obra', 
                'maquinaria', 
                'subcontratos', 
                'indirectos'
            ])->default('materiales');
            
            // Cantidades y precios
            $table->string('unidad', 20)->default('global'); // m³, m², kg, pza, global, etc.
            $table->decimal('cantidad', 12, 2)->default(1);
            $table->decimal('precio_unitario', 12, 2)->default(0);
            
            // Importe calculado (cantidad * precio_unitario)
            $table->decimal('importe', 12, 2)->storedAs('cantidad * precio_unitario');
            
            // Metadatos
            $table->integer('orden')->default(0);            // Para ordenar partidas
            $table->boolean('activa')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para búsquedas rápidas
            $table->index(['proyecto_id', 'seccion']);
            $table->index(['proyecto_id', 'categoria']);
            $table->index('codigo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_partidas');
    }
};