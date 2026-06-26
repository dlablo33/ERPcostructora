<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            
            // Tipo y nombre
            $table->enum('tipo', ['foto', 'acta'])->comment('Tipo de evidencia: foto o acta');
            $table->string('nombre', 255)->comment('Nombre de la evidencia');
            $table->text('descripcion')->nullable()->comment('Descripción detallada');
            
            // Relaciones
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // ✅ QUITAR LA FOREIGN KEY TEMPORALMENTE
            $table->unsignedBigInteger('categoria_id')->nullable()->comment('ID de la categoría');
            // $table->foreignId('categoria_id')->nullable()->constrained('categorias_evidencia')->onDelete('set null');
            
            // Campo directo como fallback
            $table->string('categoria_nombre', 50)->nullable()->comment('Nombre de la categoría (fallback)');
            
            // Fechas
            $table->date('fecha')->comment('Fecha de la evidencia');
            
            // Usuario que subió
            $table->foreignId('subido_por')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // Archivos
            $table->string('archivo_path', 255)->comment('Ruta del archivo');
            $table->string('archivo_nombre', 255)->comment('Nombre original del archivo');
            $table->bigInteger('tamanio_bytes')->default(0)->comment('Tamaño en bytes');
            $table->string('tipo_archivo', 20)->nullable()->comment('Extensión: JPG, PNG, PDF');
            
            // Miniatura
            $table->string('miniatura_path', 255)->nullable()->comment('Ruta de la miniatura');
            
            // Metadatos
            $table->json('metadatos')->nullable()->comment('Metadatos adicionales (EXIF, etc.)');
            
            // Dimensiones
            $table->integer('ancho')->nullable()->comment('Ancho de la imagen en píxeles');
            $table->integer('alto')->nullable()->comment('Alto de la imagen en píxeles');
            
            // Estado
            $table->enum('estado', ['activo', 'archivado', 'eliminado'])
                ->default('activo')
                ->comment('Estado de la evidencia');
            
            // Auditoría
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
            $table->index('tipo');
            $table->index('fecha');
            $table->index('estado');
            $table->index(['proyecto_id', 'tipo']);
            $table->index(['proyecto_id', 'categoria_id']);
            $table->index(['proyecto_id', 'fecha']);
            $table->index(['tipo', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};