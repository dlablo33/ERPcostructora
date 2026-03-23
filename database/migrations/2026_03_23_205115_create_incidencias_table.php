<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_incidencias_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id('incidencia_id');
            $table->foreignId('plantilla_id')->constrained('plantillas', 'plantilla_id')->onDelete('cascade');
            $table->foreignId('cat_tipo_incidencia_id')->constrained('cat_tipos_incidencias', 'cat_tipo_incidencia_id');
            $table->text('descripcion');
            $table->date('fecha_incidencia');
            $table->enum('estatus', ['Pendiente', 'Aprobada', 'Rechazada', 'Resuelta'])->default('Pendiente');
            $table->date('fecha_resolucion')->nullable();
            $table->text('comentarios_resolucion')->nullable();
            $table->foreignId('autorizado_por')->nullable()->constrained('plantillas', 'plantilla_id');
            $table->date('fecha_autorizacion')->nullable();
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('fecha_incidencia');
            $table->index('estatus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};