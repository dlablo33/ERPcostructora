<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licitaciones', function (Blueprint $table) {
            // Identificador principal
            $table->id();
            
            // Datos generales de la licitación
            $table->string('no_licitacion', 50)->unique()->comment('Número único de la licitación');
            $table->string('nombre', 500)->comment('Nombre o descripción de la licitación');
            $table->text('descripcion')->nullable()->comment('Descripción detallada');
            
            // Relaciones con otras tablas
            $table->foreignId('cliente_id')->nullable()->constrained('contactos', 'contacto_id')->nullOnDelete()->comment('Cliente/Dependencia que publica');
            $table->foreignId('responsable_id')->nullable()->constrained('plantillas', 'plantilla_id')->nullOnDelete()->comment('Responsable del proceso de licitación');
            $table->foreignId('created_by')->constrained('users')->comment('Usuario que creó el registro');
            
            // Fechas clave del proceso
            $table->date('fecha_publicacion')->comment('Fecha de publicación de la convocatoria');
            $table->date('fecha_cierre')->comment('Fecha límite para participar');
            
            // Datos económicos
            $table->decimal('monto_estimado', 15, 2)->default(0)->comment('Monto estimado del proyecto');
            $table->string('moneda', 3)->default('MXN')->comment('Tipo de moneda (MXN, USD, EUR)');
            
            // Estados y seguimiento
            $table->enum('estado', [
                'En Proceso',
                'Por Vencer', 
                'Vencida',
                'Adjudicada',
                'No Adjudicada'
            ])->default('En Proceso')->comment('Estado actual de la licitación');
            
            $table->boolean('participa')->default(false)->comment('¿Nuestra empresa participa?');
            $table->date('fecha_participacion')->nullable()->comment('Fecha en que se confirmó participación');
            $table->date('fecha_adjudicacion')->nullable()->comment('Fecha en que se adjudicó (si aplica)');
            
            // Relación con proyecto (cuando se convierte)
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->comment('Proyecto generado si se adjudica');
            
            // Documentación y seguimiento
            $table->json('documentos')->nullable()->comment('Lista de documentos adjuntos (convocatoria, bases, etc.)');
            $table->json('historial_movimientos')->nullable()->comment('Historial de cambios de estado y acciones');
            $table->text('observaciones')->nullable()->comment('Notas internas adicionales');
            
            // Auditoría y control
            $table->softDeletes();
            $table->timestamps();
            
            // Índices para optimizar consultas
            $table->index('no_licitacion');
            $table->index('estado');
            $table->index('fecha_publicacion');
            $table->index('fecha_cierre');
            $table->index('participa');
            $table->index('cliente_id');
            $table->index('responsable_id');
            $table->index(['estado', 'fecha_cierre'], 'idx_estado_fecha_cierre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licitaciones');
    }
};