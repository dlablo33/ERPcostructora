<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_documentos_contratista_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos_contratista', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('contratista_id')
                ->constrained('contratistas')
                ->onDelete('cascade');
            
            $table->foreignId('asignacion_id')
                ->nullable()
                ->constrained('asignaciones_contratistas')
                ->onDelete('set null');
            
            // Datos del documento
            $table->string('tipo_documento', 50);
            $table->string('nombre_original', 200);
            $table->string('ruta_archivo', 500);
            $table->date('fecha_subida')->default(now());
            $table->date('fecha_vencimiento')->nullable();
            
            // Auditoría
            $table->foreignId('subido_por')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            
            $table->text('observaciones')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index('tipo_documento');
            $table->index('fecha_vencimiento');
            $table->index(['contratista_id', 'tipo_documento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_contratista');
    }
};