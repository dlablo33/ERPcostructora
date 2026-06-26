<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pruebas_calidad', function (Blueprint $table) {
            $table->id();
            
            // Número de prueba único (ej: LAB-2026-001)
            $table->string('no_prueba')->unique()->comment('Número de prueba único');
            
            // Relación con proyecto
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // Información de la prueba
            $table->string('tipo_prueba', 100)->comment('Tipo de prueba: Concreto, Acero, Soldadura, etc.');
            $table->string('elemento', 255)->comment('Ubicación o elemento inspeccionado');
            $table->date('fecha')->comment('Fecha de realización de la prueba');
            
            // Resultado
            $table->enum('resultado', ['Aprobada', 'Rechazada', 'Pendiente'])
                ->default('Pendiente')
                ->comment('Resultado de la prueba');
            
            // Responsable
            $table->foreignId('responsable_id')
                ->constrained('plantillas', 'plantilla_id')
                ->onDelete('restrict')
                ->onUpdate('cascade')
                ->comment('Responsable de la prueba');
            
            // Datos del laboratorio
            $table->string('laboratorio', 100)->nullable()->comment('Nombre del laboratorio');
            
            // Valores de la prueba
            $table->string('valor', 50)->nullable()->comment('Valor obtenido en la prueba');
            $table->string('especificacion', 50)->nullable()->comment('Valor especificado');
            $table->string('norma', 50)->nullable()->comment('Norma aplicada');
            
            // Observaciones y documentos
            $table->text('observaciones')->nullable()->comment('Observaciones de la prueba');
            $table->string('certificado_path')->nullable()->comment('Ruta del certificado PDF');
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejorar rendimiento
            $table->index('fecha');
            $table->index('resultado');
            $table->index('tipo_prueba');
            $table->index(['proyecto_id', 'fecha']);
            $table->index(['proyecto_id', 'resultado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pruebas_calidad');
    }
};