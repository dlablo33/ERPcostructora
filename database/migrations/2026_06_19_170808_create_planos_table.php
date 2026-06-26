<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            
            // Identificación del plano
            $table->string('no_plano', 50)->comment('Número de plano (ej: A-001)');
            $table->string('nombre', 255)->comment('Nombre descriptivo del plano');
            
            // Relaciones
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // Clasificación
            $table->string('disciplina', 50)->comment('Arquitectura, Estructura, Instalaciones, etc.');
            $table->string('subdisciplina', 50)->nullable()->comment('Subcategoría dentro de la disciplina');
            
            // Versiones y estado
            $table->string('revision', 10)->default('Rev.0')->comment('Revisión actual');
            $table->enum('estado', ['Aprobado', 'En Revisión', 'Pendiente'])
                ->default('Pendiente')
                ->comment('Estado del plano');
            
            // Fechas
            $table->date('fecha')->comment('Fecha del plano');
            $table->date('fecha_aprobacion')->nullable()->comment('Fecha de aprobación');
            
            // Formato y tamaño
            $table->string('formato', 20)->default('DWG')->comment('DWG, PDF, DXF, etc.');
            $table->string('escala', 20)->nullable()->comment('Escala del plano');
            $table->bigInteger('tamanio_bytes')->default(0)->comment('Tamaño del archivo en bytes');
            
            // Descripción
            $table->text('descripcion')->nullable()->comment('Descripción del plano');
            
            // Archivos
            $table->string('documento_path', 255)->nullable()->comment('Ruta del archivo original');
            $table->string('documento_nombre', 255)->nullable()->comment('Nombre original del archivo');
            $table->string('miniatura_path', 255)->nullable()->comment('Ruta de la miniatura/imagen');
            
            // Auditoría
            $table->foreignId('ultima_revision_por')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->comment('Usuario que hizo la última revisión');
            
            $table->foreignId('aprobado_por')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->comment('Usuario que aprobó el plano');
            
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->unique(['proyecto_id', 'no_plano'])->comment('Un proyecto no puede tener dos planos con el mismo número');
            $table->index('disciplina');
            $table->index('estado');
            $table->index('revision');
            $table->index(['proyecto_id', 'disciplina']);
            $table->index(['proyecto_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planos');
    }
};