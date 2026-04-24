<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones_articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisicion_articulo_id')->constrained('requisicion_articulos')->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->decimal('precio_unitario', 15, 2);
            $table->integer('tiempo_entrega_dias')->nullable();
            $table->string('condiciones_pago', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estatus', ['Pendiente', 'Seleccionada', 'Rechazada'])->default('Pendiente');
            $table->foreignId('creado_por')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index('requisicion_articulo_id');
            $table->index('proveedor_id');
            $table->index('estatus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones_articulos');
    }
};