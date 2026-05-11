<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id('contacto_id');
            $table->string('razon_social', 200);
            $table->string('rfc', 13)->unique();
            $table->string('nombre_comercial', 150)->nullable();
            $table->string('email_facturacion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('satcat_regimen_fiscal_clave', 5);
            $table->string('satcat_uso_cfdi_clave', 5);
            $table->string('satcat_formas_pago_clave', 5)->nullable();
            $table->string('satcat_metodos_pago_clave', 5)->nullable();
            $table->string('calle', 150)->nullable();
            $table->string('num_exterior', 20)->nullable();
            $table->string('num_interior', 20)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('pais', 3)->default('MEX');
            $table->enum('tipo', ['cliente', 'proveedor', 'ambos'])->default('cliente');
            $table->integer('dias_credito')->default(0);
            $table->decimal('limite_credito', 14, 2)->default(0);
            $table->boolean('estatus')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contactos');
    }
};