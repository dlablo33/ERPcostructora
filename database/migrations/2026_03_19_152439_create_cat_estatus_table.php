<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_estatus', function (Blueprint $table) {
            $table->id('cat_estatus_id');
            $table->string('estatus');
            $table->string('clave', 50)->nullable();
            $table->string('tipo')->nullable();
            $table->string('color')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_estatus');
    }
};