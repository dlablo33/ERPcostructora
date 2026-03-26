<?php
// database/migrations/2026_03_25_180001_create_asistencias_table.php

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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 20)->unique();
            
            // Referencias (una de las dos puede ser nula, pero no ambas)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('plantilla_id')->nullable();
            
            // Datos de asistencia
            $table->date('fecha');
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->enum('tipo_registro', ['entrada', 'salida', 'incidencia'])->default('entrada');
            $table->enum('estatus', ['Activo', 'Pendiente', 'Justificado', 'Falta', 'Retardo'])->default('Activo');
            $table->text('observaciones')->nullable();
            
            // Quién registró
            $table->unsignedBigInteger('registrado_por')->nullable();
            
            // Para reportes semanales
            $table->date('semana_inicio')->nullable();
            $table->date('semana_fin')->nullable();
            $table->string('semana', 10)->nullable(); // Formato: YYYY-WW
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para búsquedas rápidas
            $table->index(['user_id', 'fecha']);
            $table->index(['plantilla_id', 'fecha']);
            $table->index('fecha');
            $table->index('semana');
            $table->index('estatus');
            
            // Llaves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plantilla_id')->references('plantilla_id')->on('plantillas')->onDelete('cascade');
            $table->foreign('registrado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};