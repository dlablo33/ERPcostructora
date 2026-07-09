<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_gastos_contratista_table.php

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
        Schema::create('gastos_contratista', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('asignacion_id')
                ->constrained('asignaciones_contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('contratista_id')
                ->constrained('contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade');
            
            // Datos del gasto
            $table->string('tipo_gasto', 50);
            $table->string('concepto', 200);
            $table->text('descripcion')->nullable();
            $table->date('fecha_gasto');
            $table->decimal('monto', 15, 2);
            
            // Documentación
            $table->string('factura', 50)->nullable();
            $table->string('proveedor_externo', 200)->nullable();
            $table->string('comprobante_path', 500)->nullable();
            
            // Estado de pago
            $table->string('status_pago', 20)->default('pendiente');
            $table->date('fecha_pago')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('tipo_gasto');
            $table->index('status_pago');
            $table->index('fecha_gasto');
            $table->index(['asignacion_id', 'tipo_gasto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos_contratista');
    }
};