<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cat_tipos_comprobante', function (Blueprint $table) {
            $table->id('cat_tipo_comprobante_id');
            $table->string('clave', 1)->unique(); // I, E, T, P, N
            $table->string('descripcion', 100);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_tipos_comprobante');
    }
};