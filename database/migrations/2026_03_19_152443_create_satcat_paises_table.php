<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satcat_paises', function (Blueprint $table) {
            $table->id('satcat_pais_id');
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->string('nacionalidad')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satcat_paises');
    }
};