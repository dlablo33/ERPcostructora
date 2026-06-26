<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicadores_calidad', function (Blueprint $table) {
            $table->id();
            
            // Relación con proyecto (único por proyecto)
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->unique();
            
            // Métricas principales
            $table->integer('total_pruebas')->default(0)->comment('Total de pruebas realizadas');
            $table->integer('aprobadas')->default(0)->comment('Pruebas aprobadas');
            $table->integer('rechazadas')->default(0)->comment('Pruebas rechazadas');
            
            // Porcentajes
            $table->decimal('porcentaje_aprobacion', 8, 2)
                ->default(0)
                ->comment('Porcentaje de aprobación');
            
            // Indicadores clave
            $table->decimal('indice_calidad', 8, 2)
                ->default(0)
                ->comment('Índice de calidad general (0-100)');
            
            $table->decimal('eficiencia_inspeccion', 8, 2)
                ->default(0)
                ->comment('Eficiencia de inspección');
            
            $table->decimal('cumplimiento_normativo', 8, 2)
                ->default(0)
                ->comment('Cumplimiento con normas');
            
            $table->decimal('tiempo_respuesta', 8, 2)
                ->default(0)
                ->comment('Tiempo promedio de respuesta (días)');
            
            // Fecha de actualización
            $table->date('fecha_actualizacion')->nullable()->comment('Última fecha de actualización');
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('porcentaje_aprobacion');
            $table->index('indice_calidad');
            $table->index('fecha_actualizacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicadores_calidad');
    }
};