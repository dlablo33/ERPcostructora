<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleado_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plantilla_id');
            $table->foreign('plantilla_id')->references('plantilla_id')->on('plantillas')->onDelete('cascade');
            $table->string('nombre_documento'); // Nombre del documento (ej: Acta de nacimiento)
            $table->string('archivo'); // Ruta del archivo
            $table->string('tipo_archivo'); // pdf, jpg, png
            $table->integer('tamanio'); // Tamaño en bytes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado_documentos');
    }
};