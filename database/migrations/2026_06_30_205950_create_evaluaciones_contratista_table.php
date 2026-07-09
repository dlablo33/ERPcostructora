<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_evaluaciones_contratista_table.php

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
        Schema::create('evaluaciones_contratista', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('contratista_id')
                ->constrained('contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('asignacion_id')
                ->nullable()
                ->constrained('asignaciones_contratistas')
                ->onDelete('set null');
            
            $table->foreignId('evaluador_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            // Datos de evaluación
            $table->date('fecha_evaluacion');
            $table->decimal('calidad', 3, 2); // 0-10
            $table->decimal('cumplimiento', 3, 2); // 0-10
            $table->decimal('seguridad', 3, 2); // 0-10
            $table->decimal('comunicacion', 3, 2); // 0-10
            $table->decimal('promedio', 3, 2);
            
            // Comentarios
            $table->text('comentarios')->nullable();
            $table->text('fortalezas')->nullable();
            $table->text('areas_mejora')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index('fecha_evaluacion');
            $table->index(['contratista_id', 'fecha_evaluacion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_contratista');
    }
};