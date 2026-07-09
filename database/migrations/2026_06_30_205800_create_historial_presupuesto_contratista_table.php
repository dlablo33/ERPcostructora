<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_historial_presupuesto_contratista_table.php

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
        Schema::create('historial_presupuesto_contratista', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('asignacion_id')
                ->constrained('asignaciones_contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('contratista_id')
                ->constrained('contratistas')
                ->onDelete('cascade');
            
            // Datos históricos
            $table->decimal('presupuesto_anterior', 15, 2)->nullable();
            $table->decimal('presupuesto_nuevo', 15, 2);
            $table->decimal('gasto_acumulado', 15, 2)->default(0);
            $table->string('motivo', 200);
            
            // Auditoría
            $table->date('fecha_cambio')->default(now());
            $table->foreignId('realizado_por')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->timestamps();
            
            // Índices
            $table->index('asignacion_id');
            $table->index('fecha_cambio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_presupuesto_contratista');
    }
};