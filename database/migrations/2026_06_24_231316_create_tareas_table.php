<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_tareas_table.php
public function up()
{
    Schema::create('tareas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_creador_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('usuario_asignado_id')->constrained('users')->onDelete('cascade');
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        $table->string('tipo'); // 'compra', 'factura', 'licitacion', etc.
        $table->json('data')->nullable(); // Guardar datos adicionales
        $table->foreignId('referencia_id')->nullable(); // ID del objeto relacionado (ej. compra_id)
        $table->string('referencia_type')->nullable(); // Clase del modelo relacionado
        $table->string('estado')->default('pendiente'); // pendiente, aceptada, rechazada, cancelada
        $table->timestamp('fecha_limite')->nullable();
        $table->timestamp('leida_at')->nullable(); // Para saber si el usuario vio la notificación
        $table->timestamps();
        
        // Índices para consultas rápidas
        $table->index(['usuario_asignado_id', 'estado']);
        $table->index(['tipo', 'estado']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
