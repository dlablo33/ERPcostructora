<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factura_cancelada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id');
            $table->unsignedBigInteger('cfdi_id')->nullable();
            $table->dateTime('fecha_peticion');
            $table->dateTime('fecha_cancelado')->nullable();
            $table->string('codigo_cancelacion')->nullable();
            $table->text('mensaje_cancelacion')->nullable();
            $table->string('estado', 20)->nullable();
            $table->string('es_cancelable', 10)->nullable();
            $table->string('estatus_cancelacion')->nullable();
            $table->string('folio_relacionado')->nullable();
            $table->string('timbrefiscaldigitalUUID_relacionado', 36)->nullable();
            $table->string('satcat_tipo_relacion_clave', 5)->nullable();
            $table->timestamps();
            
            $table->foreign('factura_id')->references('factura_id')->on('facturas');
            $table->foreign('cfdi_id')->references('cfdi_id')->on('cfdi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura_cancelada');
    }
};