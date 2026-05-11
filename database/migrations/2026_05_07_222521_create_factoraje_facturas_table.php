<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factoraje_facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->unsignedBigInteger('factura_id');
            $table->decimal('monto_factura', 12, 2);
            $table->boolean('pagada_cliente')->default(false);
            $table->date('fecha_pago_cliente')->nullable();
            $table->timestamps();
            
            $table->foreign('solicitud_id')->references('solicitud_id')->on('solicitudes_factoraje')->onDelete('cascade');
            $table->foreign('factura_id')->references('factura_id')->on('facturas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factoraje_facturas');
    }
};