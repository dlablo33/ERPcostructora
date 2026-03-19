<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_tipos_licencia', function (Blueprint $table) {
            $table->id('cat_tipo_licencia_id');
            $table->string('tipo_licencia');
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_tipos_licencia');
    }
};