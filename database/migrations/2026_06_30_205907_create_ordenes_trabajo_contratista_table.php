<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_ordenes_trabajo_contratista_table.php

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
        Schema::create('ordenes_trabajo_contratista', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('asignacion_id')
                ->constrained('asignaciones_contratistas')
                ->onDelete('cascade');
            
            // Datos de la orden
            $table->string('folio', 50)->unique();
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->decimal('monto_estimado', 15, 2)->nullable();
            
            // Estado
            $table->string('status', 20)->default('emitida');
            
            // Aceptación
            $table->foreignId('aceptada_por')
                ->nullable()
                ->constrained('contratistas')
                ->onDelete('set null');
            $table->date('fecha_aceptacion')->nullable();
            
            // Observaciones
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->timestamps();
            
            // Índices
            $table->index('status');
            $table->index('fecha_emision');
            $table->index('folio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo_contratista');
    }
};