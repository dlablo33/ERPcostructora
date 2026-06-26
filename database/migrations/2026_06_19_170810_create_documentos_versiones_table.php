<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_versiones', function (Blueprint $table) {
            $table->id();
            
            // Tipo de documento
            $table->enum('documento_tipo', ['contrato', 'plano'])
                ->comment('Tipo de documento: contrato o plano');
            
            // ID del documento relacionado
            $table->bigInteger('documento_id')->comment('ID del contrato o plano');
            
            // Versión
            $table->string('version', 10)->comment('v1.0, v1.5, v2.0, etc.');
            $table->string('nombre_version', 100)->nullable()->comment('Nombre descriptivo de la versión');
            
            // Fechas
            $table->datetime('fecha_version')->comment('Fecha de creación de la versión');
            
            // Usuario
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->comment('Usuario que subió la versión');
            
            // Cambios
            $table->text('cambios')->nullable()->comment('Descripción de los cambios realizados');
            
            // Archivo
            $table->string('documento_path', 255)->comment('Ruta del archivo de la versión');
            $table->string('documento_nombre', 255)->nullable()->comment('Nombre original del archivo');
            $table->bigInteger('tamanio_bytes')->default(0)->comment('Tamaño del archivo en bytes');
            
            // Flag de versión actual
            $table->boolean('es_actual')->default(false)->comment('Indica si es la versión actual');
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index(['documento_tipo', 'documento_id']);
            $table->index('es_actual');
            $table->index('version');
            $table->index('fecha_version');
            
            // Índice compuesto para búsquedas rápidas
            $table->index(['documento_tipo', 'documento_id', 'es_actual']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_versiones');
    }
};