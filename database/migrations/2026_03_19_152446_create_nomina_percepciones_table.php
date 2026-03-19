<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomina_percepciones', function (Blueprint $table) {
            $table->id('nomina_percepcion_id');
            $table->unsignedBigInteger('plantilla_id');
            $table->string('clave_sat', 10);
            $table->string('concepto');
            $table->decimal('importe_gravado', 10, 2)->default(0);
            $table->decimal('importe_exento', 10, 2)->default(0);
            $table->string('tipo_percepcion')->nullable();
            $table->date('fecha_aplicacion');
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plantilla_id')->references('plantilla_id')->on('plantillas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomina_percepciones');
    }
};