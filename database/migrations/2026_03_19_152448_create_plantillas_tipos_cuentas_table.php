<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantillas_tipos_cuentas', function (Blueprint $table) {
            $table->id('plantilla_tipo_cuenta_id');
            $table->unsignedBigInteger('plantilla_id');
            $table->unsignedBigInteger('cat_tipo_cuenta_id');
            $table->string('cuenta');
            $table->string('cuenta_clabe', 20);
            $table->string('alias')->nullable();
            $table->unsignedBigInteger('cat_banco_id')->nullable();
            $table->boolean('principal')->default(false);
            $table->boolean('activo')->default(true);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plantilla_id')->references('plantilla_id')->on('plantillas');
            $table->foreign('cat_tipo_cuenta_id')->references('cat_tipo_cuenta_id')->on('cat_tipos_cuenta');
            $table->foreign('cat_banco_id')->references('cat_banco_id')->on('cat_bancos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantillas_tipos_cuentas');
    }
};