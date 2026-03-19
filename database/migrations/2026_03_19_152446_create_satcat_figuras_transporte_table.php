<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satcat_figuras_transporte', function (Blueprint $table) {
            $table->id('satcat_figura_transporte_id');
            $table->string('clave', 10)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satcat_figuras_transporte');
    }
};