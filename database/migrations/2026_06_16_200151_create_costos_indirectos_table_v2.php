<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costos_indirectos', function (Blueprint $table) {
            $table->id();
            
            // Relaciones principales
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->nullOnDelete();
            
            // Datos del costo
            $table->enum('categoria', [
                'personal_tecnico',
                'administracion',
                'seguridad',
                'servicios',
                'herramienta'
            ])->default('personal_tecnico');
            
            $table->string('concepto', 500);
            $table->date('fecha');
            
            // Datos del proveedor
            $table->string('proveedor_nombre', 200)->nullable();
            $table->string('rfc', 20)->nullable();
            $table->string('factura', 100)->nullable();
            $table->text('descripcion')->nullable();
            
            // Valores monetarios
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('iva', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            
            // Pago
            $table->enum('forma_pago', ['transferencia', 'cheque', 'efectivo', 'tarjeta'])
                ->default('transferencia');
            $table->date('fecha_pago')->nullable();
            $table->enum('estatus_pago', ['pagado', 'pendiente', 'programado', 'vencido'])
                ->default('pendiente');
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices - con prefijo único para evitar conflictos
            $table->index('proyecto_id', 'indirectos_proyecto_idx');
            $table->index('categoria', 'indirectos_categoria_idx');
            $table->index('fecha', 'indirectos_fecha_idx');
            $table->index('estatus_pago', 'indirectos_estatus_idx');
            $table->index(['categoria', 'estatus_pago'], 'indirectos_cat_estatus_idx');
            $table->index(['proyecto_id', 'categoria'], 'indirectos_proy_cat_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costos_indirectos');
    }
};