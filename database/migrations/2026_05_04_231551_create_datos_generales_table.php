<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('datos_generales', function (Blueprint $table) {
            $table->id('datos_generales_id');
            $table->string('razon_social', 150);
            $table->string('rfc', 13)->unique();
            $table->string('calle', 150);
            $table->string('num_exterior', 20);
            $table->string('num_interior', 20)->nullable();
            $table->string('colonia', 100);
            $table->string('codigo_postal', 10);
            $table->string('municipio', 100);
            $table->string('estado', 100);
            $table->string('pais', 3)->default('MEX');
            $table->string('satcat_regimen_fiscal_clave', 5);
            $table->string('logo_path')->nullable();
            $table->string('certificado_cer')->nullable();
            $table->string('certificado_key')->nullable();
            $table->string('certificado_password')->nullable();
            $table->string('certificado_no_serie')->nullable(); // No. Serie del CSD
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('datos_generales');
    }
};