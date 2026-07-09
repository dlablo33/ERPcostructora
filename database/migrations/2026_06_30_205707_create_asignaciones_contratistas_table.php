<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_asignaciones_contratistas_table.php

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
        Schema::create('asignaciones_contratistas', function (Blueprint $table) {
            $table->id();
            
            // Relaciones principales
            $table->foreignId('contratista_id')
                ->constrained('contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade');
            
            $table->foreignId('partida_id')
                ->nullable()
                ->constrained('proyecto_partidas')
                ->onDelete('set null');
            
            // Datos de la asignación
            $table->string('seccion', 100)->nullable();
            $table->date('fecha_asignacion');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            
            // Presupuesto y gastos
            $table->decimal('presupuesto_asignado', 15, 2)->default(0);
            $table->decimal('gasto_acumulado', 15, 2)->default(0);
            $table->decimal('saldo_disponible', 15, 2)->default(0);
            $table->decimal('avance_porcentaje', 5, 2)->default(0);
            
            // Estado y condiciones
            $table->string('status', 20)->default('asignado');
            $table->text('condiciones_pago')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejorar rendimiento
            $table->index(['proyecto_id', 'status']);
            $table->index(['contratista_id', 'status']);
            $table->index('fecha_asignacion');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones_contratistas');
    }
};