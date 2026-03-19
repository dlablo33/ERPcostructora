<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_tipos_cuenta', function (Blueprint $table) {
            $table->id('cat_tipo_cuenta_id');
            $table->string('descripcion');
            $table->string('clave_sat')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_tipos_cuenta');
    }
};