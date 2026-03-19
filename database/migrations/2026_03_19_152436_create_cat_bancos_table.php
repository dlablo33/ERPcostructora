<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_bancos', function (Blueprint $table) {
            $table->id('cat_banco_id');
            $table->string('clave', 10)->unique();
            $table->string('descripcion');
            $table->string('nombre_corto')->nullable();
            $table->string('rfc')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_bancos');
    }
};