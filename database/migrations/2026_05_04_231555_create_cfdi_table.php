<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cfdi', function (Blueprint $table) {
            $table->id('cfdi_id');
            $table->unsignedBigInteger('factura_id');
            $table->string('timbrefiscaldigitalUUID', 36)->unique();
            $table->dateTime('timbrefiscaldigitalFechaTimbrado');
            $table->text('timbrefiscaldigitalSelloCFD')->nullable();
            $table->text('timbrefiscaldigitalSelloSAT')->nullable();
            $table->string('timbrefiscaldigitalNoCertificadoSAT', 50)->nullable();
            $table->string('comprobanteSerie', 10)->nullable();
            $table->string('comprobanteFolio', 30)->nullable();
            $table->date('comprobanteFecha');
            $table->string('comprobanteMoneda', 5);
            $table->decimal('comprobanteTipoCambio', 12, 6)->nullable();
            $table->decimal('comprobanteSubTotal', 14, 2);
            $table->decimal('comprobanteTotal', 14, 2);
            $table->string('comprobanteTipoDeComprobante', 1);
            $table->string('comprobanteMetodoPago', 5);
            $table->string('comprobanteFormaPago', 5);
            $table->string('comprobanteNoCertificado', 50)->nullable();
            $table->text('comprobanteSello')->nullable();
            $table->string('emisorRfc', 13);
            $table->string('receptorRfc', 13);
            $table->text('cadena_original')->nullable();
            $table->timestamps();
            
            $table->foreign('factura_id')->references('factura_id')->on('facturas');
            $table->index('timbrefiscaldigitalUUID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cfdi');
    }
};