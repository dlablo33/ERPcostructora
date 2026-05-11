<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('satcat_unidades', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 10)->unique();
            $table->string('descripcion', 150);
            $table->string('simbolo', 10)->nullable();
            $table->boolean('estatus')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('satcat_unidades');
    }
};