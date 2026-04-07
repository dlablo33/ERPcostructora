<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // PR-001, PR-002...
            $table->string('estatus')->default('Activo'); // Activo, Pendiente, Finalizado, Cancelado
            $table->date('fecha_inicio');
            $table->foreignId('plantilla_id')->constrained('plantillas', 'plantilla_id')->onDelete('restrict');
            $table->string('motivo');
            $table->decimal('monto', 12, 2);
            $table->decimal('monto_descuento', 12, 2);
            $table->integer('numero_pagos');
            $table->string('frecuencia'); // Semanal, Quincenal, Mensual
            $table->decimal('monto_restante', 12, 2);
            $table->text('observaciones')->nullable();
            $table->string('gasto')->nullable(); // Relación con anticipos/gastos
            $table->timestamps();
            $table->softDeletes(); // Para eliminación lógica
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};