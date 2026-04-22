<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventario_proyecto_id')->constrained('inventario_proyecto')->onDelete('restrict');
            $table->foreignId('almacen_origen_id')->nullable()->constrained('almacenes')->onDelete('set null');
            $table->foreignId('almacen_destino_id')->nullable()->constrained('almacenes')->onDelete('set null');
            $table->enum('tipo_movimiento', ['Entrada', 'Salida', 'Ajuste', 'Transferencia', 'Devolucion']);
            $table->decimal('cantidad', 12, 3);
            $table->decimal('cantidad_antes', 12, 3);
            $table->decimal('cantidad_despues', 12, 3);
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->string('referencia_folio', 50)->nullable();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->onDelete('set null');
            $table->string('solicitante', 100)->nullable();
            $table->foreignId('autorizado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->string('motivo', 255)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->foreignId('creado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('inventario_proyecto_id');
            $table->index('tipo_movimiento');
            $table->index('referencia_tipo');
            $table->index('referencia_id');
            $table->index('fecha_movimiento');
            $table->index('proveedor_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};