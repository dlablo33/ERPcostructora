<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('no_conformidades', function (Blueprint $table) {
            $table->id();
            
            // Número de NC único (ej: NC-2026-001)
            $table->string('no_nc')->unique()->comment('Número de no conformidad único');
            
            // Relación con proyecto
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // Descripción
            $table->text('descripcion')->comment('Descripción detallada de la no conformidad');
            
            // Fechas
            $table->date('fecha_deteccion')->comment('Fecha en que se detectó la no conformidad');
            $table->date('fecha_limite')->nullable()->comment('Fecha límite para corregir');
            
            // Gravedad
            $table->enum('gravedad', ['Alta', 'Media', 'Baja'])
                ->default('Media')
                ->comment('Nivel de gravedad de la no conformidad');
            
            // Responsable
            $table->foreignId('responsable_id')
                ->constrained('plantillas', 'plantilla_id')
                ->onDelete('restrict')
                ->onUpdate('cascade')
                ->comment('Responsable de atender la no conformidad');
            
            // Estado
            $table->enum('estado', ['En proceso', 'Corregida', 'Cerrada'])
                ->default('En proceso')
                ->comment('Estado actual de la no conformidad');
            
            // Acciones y causas
            $table->text('acciones_tomadas')->nullable()->comment('Acciones realizadas para corregir');
            $table->text('causa_raiz')->nullable()->comment('Causa raíz identificada');
            
            // Relación con prueba de calidad (opcional)
            $table->foreignId('prueba_id')
                ->nullable()
                ->constrained('pruebas_calidad')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->comment('Prueba de calidad relacionada');
            
            // Documentos
            $table->string('documento_path')->nullable()->comment('Ruta del documento adjunto');
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->foreignId('cerrado_por')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->comment('Usuario que cerró la no conformidad');
            
            $table->timestamp('fecha_cierre')->nullable()->comment('Fecha de cierre');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('fecha_deteccion');
            $table->index('gravedad');
            $table->index('estado');
            $table->index(['proyecto_id', 'estado']);
            $table->index(['proyecto_id', 'gravedad']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('no_conformidades');
    }
};