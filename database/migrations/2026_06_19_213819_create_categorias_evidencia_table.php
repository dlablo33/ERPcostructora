<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_evidencia', function (Blueprint $table) {
            $table->id();
            
            // Identificación
            $table->string('codigo', 20)->unique()->comment('Código de la categoría');
            $table->string('nombre', 50)->comment('Nombre de la categoría');
            $table->text('descripcion')->nullable()->comment('Descripción de la categoría');
            
            // Visualización
            $table->string('icono', 50)->default('fa-tag')->comment('Icono Font Awesome');
            $table->string('color', 20)->default('#6c757d')->comment('Color asociado');
            $table->integer('orden')->default(0)->comment('Orden de visualización');
            
            // Estado
            $table->boolean('activo')->default(true);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('activo');
            $table->index('orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_evidencia');
    }
};