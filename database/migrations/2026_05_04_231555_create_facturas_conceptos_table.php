<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('facturas_conceptos', function (Blueprint $table) {
            $table->id('factura_concepto_id');
            $table->unsignedBigInteger('factura_id');
            $table->unsignedBigInteger('partida_id')->nullable();
            $table->unsignedBigInteger('articulo_id')->nullable();
            $table->string('descripcion');
            $table->decimal('cantidad', 12, 4);
            $table->string('satcat_unidades_clave', 10);
            $table->decimal('valor_unitario', 14, 4);
            $table->decimal('importe', 14, 2);
            $table->decimal('descuento', 14, 2)->default(0);
            $table->decimal('subtotal', 14, 2);
            $table->decimal('iva', 14, 2)->default(0);
            $table->decimal('tasa_iva', 8, 4)->default(16.0000); // 16% de IVA
            $table->string('satcat_clave_productos_clave', 10);
            $table->timestamps();
            
            $table->foreign('factura_id')->references('factura_id')->on('facturas')->onDelete('cascade');
            $table->foreign('partida_id')->references('id')->on('proyecto_partidas')->onDelete('set null');
            $table->foreign('articulo_id')->references('id')->on('articulos')->onDelete('set null');
            $table->index('factura_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas_conceptos');
    }
};