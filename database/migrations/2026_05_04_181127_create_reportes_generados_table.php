<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes_generados', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['diario', 'semanal', 'mensual', 'personalizado']);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('proyecto_id')->nullable();
            $table->string('archivo_ruta')->nullable();
            $table->foreignId('generado_por')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['tipo', 'fecha_inicio', 'fecha_fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes_generados');
    }
};