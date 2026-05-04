<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hitos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('fecha_programada');
            $table->date('fecha_real')->nullable();
            $table->time('hora')->nullable();
            $table->enum('estado', ['programado', 'en_proceso', 'completado', 'retrasado'])->default('programado');
            $table->enum('prioridad', ['alta', 'media', 'baja'])->default('media');
            $table->string('tipo')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null');
            $table->json('entregables')->nullable();
            $table->json('dependencias')->nullable();
            $table->json('notificar_a')->nullable();
            $table->integer('avance')->default(0);
            $table->boolean('es_critico')->default(false);
            $table->timestamps();
            
            // Índices para mejor rendimiento
            $table->index('fecha_programada');
            $table->index('estado');
            $table->index(['proyecto_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitos');
    }
};