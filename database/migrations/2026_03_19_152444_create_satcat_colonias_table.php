<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satcat_colonias', function (Blueprint $table) {
            $table->id('satcat_colonia_id');
            $table->string('clave', 5);
            $table->string('satcat_codigos_postales_codigo_postal', 10);
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['clave', 'satcat_codigos_postales_codigo_postal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satcat_colonias');
    }
};