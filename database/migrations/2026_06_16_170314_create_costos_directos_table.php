<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costos_directos', function (Blueprint $table) {
            $table->id();
            
            // Relaciones principales
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade')->comment('Proyecto al que pertenece el costo');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->nullOnDelete()->comment('Proveedor del costo');
            $table->foreignId('empleado_id')->nullable()->constrained('plantillas', 'plantilla_id')->nullOnDelete()->comment('Empleado responsable (mano de obra)');
            
            // Datos del costo
            $table->enum('categoria', ['materiales', 'mano_obra', 'maquinaria', 'subcontratos', 'equipos'])
                ->default('materiales')
                ->comment('Categoría del costo directo');
            $table->string('concepto', 500)->comment('Concepto o descripción del costo');
            $table->date('fecha')->comment('Fecha del gasto');
            
            // Datos del proveedor/empleado
            $table->string('proveedor_nombre', 200)->nullable()->comment('Nombre del proveedor o empleado (copia)');
            $table->string('rfc', 20)->nullable()->comment('RFC del proveedor');
            $table->string('factura', 100)->nullable()->comment('Número de factura o recibo');
            $table->text('descripcion')->nullable()->comment('Descripción detallada');
            
            // Unidad y cantidades
            $table->string('unidad', 20)->nullable()->comment('Unidad de medida');
            $table->decimal('cantidad', 12, 4)->default(1)->comment('Cantidad');
            $table->decimal('precio_unitario', 15, 2)->default(0)->comment('Precio por unidad');
            
            // Valores calculados
            $table->decimal('subtotal', 15, 2)->default(0)->comment('Cantidad × Precio unitario');
            $table->decimal('iva', 15, 2)->default(0)->comment('IVA del gasto');
            $table->decimal('total', 15, 2)->default(0)->comment('Subtotal + IVA');
            
            // Pago y estado
            $table->date('fecha_pago')->nullable()->comment('Fecha de pago');
            $table->enum('estatus_pago', ['pagado', 'pendiente', 'programado', 'vencido'])
                ->default('pendiente')
                ->comment('Estatus del pago');
            $table->text('observaciones')->nullable()->comment('Notas adicionales');
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que creó');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('proyecto_id');
            $table->index('categoria');
            $table->index('fecha');
            $table->index('estatus_pago');
            $table->index(['categoria', 'estatus_pago'], 'idx_categoria_estatus');
            $table->index(['proyecto_id', 'categoria'], 'idx_proyecto_categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costos_directos');
    }
};