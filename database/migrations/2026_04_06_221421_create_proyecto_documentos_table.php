<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyecto_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->string('tipo', 50); // contrato, anexos, planos, presupuesto, programa
            $table->string('nombre_original', 255);
            $table->string('ruta', 500);
            $table->string('mime_type', 100);
            $table->bigInteger('tamaño')->comment('Tamaño en bytes');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            
            // Índices
            $table->index('proyecto_id');
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_documentos');
    }
};