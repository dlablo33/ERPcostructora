<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_puestos', function (Blueprint $table) {
            $table->id('cat_puesto_id');
            $table->string('puesto');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('cat_area_id')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cat_area_id')->references('cat_area_id')->on('cat_areas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_puestos');
    }
};