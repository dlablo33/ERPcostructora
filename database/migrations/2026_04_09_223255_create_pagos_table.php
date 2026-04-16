<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_pagos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            
            // Datos del pago
            $table->string('folio', 50)->unique();
            $table->date('fecha_pago');
            $table->decimal('monto', 15, 2);
            $table->string('concepto', 500);
            
            // Relaciones
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->onDelete('set null');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('set null');
            $table->foreignId('tipo_egreso_id')->constrained('tipos_egreso');
            $table->foreignId('categoria_gasto_id')->nullable()->constrained('categorias_gastos');
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago');
            $table->foreignId('moneda_id')->constrained('monedas');
            
            // Datos del proveedor (si no está en la tabla proveedores)
            $table->string('proveedor_nombre', 200)->nullable();
            $table->string('proveedor_rfc', 20)->nullable();
            
            // Referencias
            $table->string('referencia', 100)->nullable();
            $table->string('referencia_bancaria', 100)->nullable();
            $table->string('factura', 50)->nullable();
            
            // Estatus
            $table->enum('estatus', ['pendiente', 'procesado', 'completado', 'cancelado', 'rechazado'])->default('pendiente');
            
            // Comprobante
            $table->string('comprobante', 255)->nullable();
            
            // Auditoría
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('folio');
            $table->index('fecha_pago');
            $table->index('estatus');
            $table->index('cuenta_bancaria_id');
            $table->index('proyecto_id');
            $table->index('proveedor_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};