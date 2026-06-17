<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes_fotograficos', function (Blueprint $table) {
            $table->id();
            
            // Relaciones principales
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade')->comment('Proyecto al que pertenece la foto');
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario responsable de la foto');
            $table->foreignId('empleado_id')->nullable()->constrained('plantillas', 'plantilla_id')->nullOnDelete()->comment('Empleado responsable (alternativo)');
            
            // Datos de la foto
            $table->enum('categoria', [
                'avance',
                'calidad',
                'seguridad',
                'reunion',
                'entrega',
                'instalaciones',
                'estructura',
                'terracerias',
                'pavimentos'
            ])->default('avance')->comment('Categoría de la foto');
            
            $table->string('titulo', 255)->comment('Título de la foto');
            $table->text('descripcion')->nullable()->comment('Descripción detallada');
            $table->date('fecha')->comment('Fecha de la foto');
            
            // Datos del archivo
            $table->string('ruta', 500)->comment('Ruta de almacenamiento');
            $table->string('nombre_original', 255)->comment('Nombre original del archivo');
            $table->string('nombre_unico', 255)->comment('Nombre único generado');
            $table->string('tipo', 50)->comment('MIME type del archivo');
            $table->bigInteger('tamanio')->default(0)->comment('Tamaño en bytes');
            
            // Dimensiones de la imagen (opcional)
            $table->integer('ancho')->nullable()->comment('Ancho de la imagen en píxeles');
            $table->integer('alto')->nullable()->comment('Alto de la imagen en píxeles');
            
            // Metadatos adicionales
            $table->json('exif')->nullable()->comment('Metadatos EXIF de la imagen');
            $table->enum('estado', ['activo', 'archivado'])->default('activo')->comment('Estado de la foto');
            $table->text('observaciones')->nullable()->comment('Notas adicionales');
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que creó el registro');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimización
            $table->index('proyecto_id', 'idx_reportes_fotos_proyecto');
            $table->index('categoria', 'idx_reportes_fotos_categoria');
            $table->index('fecha', 'idx_reportes_fotos_fecha');
            $table->index('estado', 'idx_reportes_fotos_estado');
            $table->index(['proyecto_id', 'categoria'], 'idx_reportes_fotos_proy_cat');
            $table->index(['fecha', 'categoria'], 'idx_reportes_fotos_fecha_cat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes_fotograficos');
    }
};