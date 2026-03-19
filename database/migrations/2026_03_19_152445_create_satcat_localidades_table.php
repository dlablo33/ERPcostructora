<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satcat_localidades', function (Blueprint $table) {
            $table->id('satcat_localidad_id');
            $table->string('clave', 5);
            $table->string('satcat_estados_clave', 5);
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['clave', 'satcat_estados_clave']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satcat_localidades');
    }
};