<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('client_tickets', function (Blueprint $table) {
            $table->id();
            
            // Cliente que crea el ticket
            $table->foreignId('cliente_id')->constrained('users');
            
            // Información del ticket
            $table->string('titulo', 255);
            $table->text('descripcion');
            $table->enum('tipo', ['error', 'solicitud', 'mejora'])->default('solicitud');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->enum('estado', [
                'pendiente', 
                'en_revision', 
                'info_requerida', 
                'rechazado', 
                'aprobado', 
                'en_desarrollo', 
                'completado', 
                'correccion'
            ])->default('pendiente');
            
            // Gestión interna
            $table->foreignId('soporte_id')->nullable()->constrained('users');
            $table->foreignId('desarrollador_id')->nullable()->constrained('desarrolladores_acceso');
            
            // Tiempos
            $table->integer('tiempo_estimado')->nullable(); // Horas
            $table->integer('tiempo_real')->nullable(); // Horas
            
            // Motivos
            $table->text('motivo_rechazo')->nullable();
            $table->text('info_requerida')->nullable();
            $table->text('correcciones')->nullable();
            
            // Fechas de seguimiento
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->timestamp('fecha_asignacion')->nullable();
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_completado')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('estado');
            $table->index('prioridad');
            $table->index('cliente_id');
            $table->index('desarrollador_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_tickets');
    }
};