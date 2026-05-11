<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacora_entries', function (Blueprint $table) {
            $table->id();
            $table->string('proyecto_id', 50);
            $table->enum('tipo', ['actividad', 'incidencia', 'acuerdo', 'nota']);
            $table->string('titulo');
            $table->text('descripcion');
            $table->date('fecha');
            $table->time('hora');
            $table->string('responsable');
            $table->string('personal')->nullable();
            $table->string('maquinaria')->nullable();
            $table->string('materiales')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cerrado'])->default('pendiente');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para búsquedas rápidas
            $table->index(['proyecto_id', 'fecha']);
            $table->index('tipo');
            $table->index('estado');
            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora_entries');
    }
};