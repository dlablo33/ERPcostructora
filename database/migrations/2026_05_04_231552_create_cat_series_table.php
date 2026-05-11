<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cat_series', function (Blueprint $table) {
            $table->id('cat_serie_id');
            $table->string('serie', 10)->unique();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('datos_generales_id');
            $table->string('cat_tipo_comprobante', 1); // I = Ingreso, E = Egreso, T = Traslado, P = Pago, N = Nómina
            $table->integer('folio_actual')->default(0);
            $table->integer('folio_final')->nullable();
            $table->string('satcat_csd_id')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->foreign('datos_generales_id')->references('datos_generales_id')->on('datos_generales');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_series');
    }
};