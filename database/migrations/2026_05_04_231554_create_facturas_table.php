<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('factura_id');
            $table->unsignedBigInteger('contacto_id');
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->unsignedBigInteger('cat_serie_id');
            $table->unsignedBigInteger('cat_sucursal_id');
            $table->string('folio', 30);
            $table->date('fecha');
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_revision')->nullable();
            $table->string('satcat_metodos_pago_clave', 5);
            $table->string('satcat_formas_pago_clave', 5);
            $table->string('satcat_uso_cfdi_clave', 5);
            $table->string('satcat_regimen_fiscal_clave', 5);
            $table->string('cat_monedas_clave', 5)->default('MXN');
            $table->decimal('tipo_cambio', 12, 6)->default(1.000000);
            $table->decimal('subtotal', 14, 2);
            $table->decimal('descuento', 14, 2)->default(0);
            $table->decimal('iva', 14, 2)->default(0);
            $table->decimal('riva', 14, 2)->default(0);
            $table->decimal('total', 14, 2);
            $table->text('observaciones')->nullable();
            $table->string('referencia')->nullable();
            $table->integer('estatus')->default(1); // 1=borrador, 19=timbrada, 20=cancelación en proceso, 21=cancelada
            $table->text('xml')->nullable();
            $table->integer('version')->default(1);
            $table->unsignedBigInteger('poliza_contable_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('refacturacion')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('contacto_id')->references('contacto_id')->on('contactos');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('set null');
            $table->foreign('cat_serie_id')->references('cat_serie_id')->on('cat_series');
            $table->foreign('cat_sucursal_id')->references('cat_sucursal_id')->on('cat_sucursales');
            $table->index('estatus');
            $table->index('folio');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
};