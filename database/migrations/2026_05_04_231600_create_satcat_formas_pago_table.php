<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('satcat_formas_pago', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion', 150);
            $table->boolean('estatus')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('satcat_formas_pago');
    }
};