<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factura_relacionado', function (Blueprint $table) {
            $table->id('facturas_relacionado_id');
            $table->unsignedBigInteger('factura_id');
            $table->unsignedBigInteger('relacion_factura_id');
            $table->string('folio', 30);
            $table->string('timbrefiscaldigitalUUID', 36);
            $table->string('satcat_tipo_relacion_clave', 5);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            
            $table->foreign('factura_id')->references('factura_id')->on('facturas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura_relacionado');
    }
};