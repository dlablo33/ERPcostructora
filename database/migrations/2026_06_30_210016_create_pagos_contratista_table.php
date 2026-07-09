<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_pagos_contratista_table.php

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
        Schema::create('pagos_contratista', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('contratista_id')
                ->constrained('contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('asignacion_id')
                ->constrained('asignaciones_contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('gasto_id')
                ->nullable()
                ->constrained('gastos_contratista')
                ->onDelete('set null');
            
            // Datos del pago
            $table->string('folio', 50)->unique();
            $table->date('fecha_pago');
            $table->decimal('monto', 15, 2);
            $table->string('forma_pago', 50); // transferencia, cheque, efectivo
            $table->string('referencia', 100)->nullable();
            
            // Comprobación
            $table->string('comprobante_path', 500)->nullable();
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('folio');
            $table->index('fecha_pago');
            $table->index(['contratista_id', 'fecha_pago']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_contratista');
    }
};