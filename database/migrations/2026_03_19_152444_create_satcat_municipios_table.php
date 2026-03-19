<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satcat_municipios', function (Blueprint $table) {
            $table->id('satcat_municipio_id');
            $table->string('clave', 5);
            $table->string('clave_satcat_estados', 5);
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['clave', 'clave_satcat_estados']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satcat_municipios');
    }
};