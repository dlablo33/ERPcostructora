<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satcat_estados', function (Blueprint $table) {
            $table->id('satcat_estado_id');
            $table->string('clave', 5);
            $table->string('clave_satcat_paises', 5);
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['clave', 'clave_satcat_paises']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satcat_estados');
    }
};