<?php

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
        Schema::create('programacion_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->nullable();
            $table->enum('estatus', ['Programado', 'Pendiente', 'Pagado', 'Cancelado', 'Parcial'])->default('Pendiente');
            $table->date('fecha');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores', 'id')->onDelete('set null');
            $table->string('descripcion', 255)->nullable();
            $table->decimal('monto', 12, 2)->default(0);
            $table->decimal('saldo', 12, 2)->default(0);
            $table->date('fecha_estimada_pago')->nullable();
            $table->date('fecha_pago_real')->nullable();
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos', 'id')->onDelete('set null');
            $table->foreignId('cuenta_bancaria_id')->nullable()->constrained('cuentas_bancarias', 'id')->onDelete('set null');
            $table->string('referencia_pago', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para búsquedas rápidas
            $table->index('estatus');
            $table->index('fecha');
            $table->index('fecha_estimada_pago');
            $table->index('proveedor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programacion_pagos');
    }
};