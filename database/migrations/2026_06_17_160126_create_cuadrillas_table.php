<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuadrillas', function (Blueprint $table) {
            $table->id();
            
            // Datos principales
            $table->string('codigo', 20)->unique()->comment('Código de la cuadrilla (A, B, C, etc.)');
            $table->string('nombre', 100)->comment('Nombre de la cuadrilla');
            $table->text('descripcion')->nullable()->comment('Descripción de la cuadrilla');
            
            // Especialidad
            $table->enum('especialidad', [
                'cimentacion',
                'estructura',
                'acabados',
                'instalaciones',
                'obra_negra',
                'albanileria',
                'herreria',
                'electricidad',
                'plomeria',
                'pintura'
            ])->default('albanileria')->comment('Especialidad de la cuadrilla');
            
            // Relaciones
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->comment('Proyecto al que pertenece la cuadrilla');
            $table->foreignId('encargado_id')->nullable()->constrained('plantillas', 'plantilla_id')->nullOnDelete()->comment('Encargado de la cuadrilla');
            
            // Integrantes (como JSON para flexibilidad)
            $table->json('integrantes')->nullable()->comment('Lista de IDs de empleados en la cuadrilla');
            
            // Estado
            $table->enum('estatus', ['activo', 'inactivo'])->default('activo')->comment('Estatus de la cuadrilla');
            $table->text('observaciones')->nullable()->comment('Observaciones adicionales');
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que creó el registro');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('codigo', 'idx_cuadrillas_codigo');
            $table->index('especialidad', 'idx_cuadrillas_especialidad');
            $table->index('estatus', 'idx_cuadrillas_estatus');
            $table->index('proyecto_id', 'idx_cuadrillas_proyecto');
            $table->index('encargado_id', 'idx_cuadrillas_encargado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuadrillas');
    }
};