<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_alertas_contratista_table.php

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
        Schema::create('alertas_contratista', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('contratista_id')
                ->constrained('contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('asignacion_id')
                ->nullable()
                ->constrained('asignaciones_contratistas')
                ->onDelete('set null');
            
            // Datos de alerta
            $table->string('tipo', 50); // presupuesto, vencimiento, documento, evaluacion
            $table->string('titulo', 200);
            $table->text('descripcion');
            $table->string('nivel', 20)->default('info'); // info, warning, danger
            $table->boolean('leida')->default(false);
            $table->date('fecha_limite')->nullable();
            
            // Auditoría
            $table->foreignId('generada_por')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->timestamps();
            
            // Índices
            $table->index(['contratista_id', 'leida']);
            $table->index(['tipo', 'leida']);
            $table->index('fecha_limite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas_contratista');
    }
};