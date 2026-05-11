<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cat_sucursales', function (Blueprint $table) {
            $table->id('cat_sucursal_id');
            $table->string('nombre', 100);
            $table->string('codigo', 20)->unique();
            $table->string('calle', 150);
            $table->string('num_exterior', 20);
            $table->string('num_interior', 20)->nullable();
            $table->string('colonia', 100);
            $table->string('codigo_postal', 10);
            $table->string('municipio', 100);
            $table->string('estado', 100);
            $table->string('pais', 3)->default('MEX');
            $table->string('email')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->unsignedBigInteger('datos_generales_id');
            $table->boolean('estatus')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('datos_generales_id')->references('datos_generales_id')->on('datos_generales');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_sucursales');
    }
};