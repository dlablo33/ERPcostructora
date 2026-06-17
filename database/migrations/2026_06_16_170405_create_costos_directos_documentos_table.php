<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costos_directos_documentos', function (Blueprint $table) {
            $table->id();
            
            // Relación con el costo directo
            $table->foreignId('costo_directo_id')
                ->constrained('costos_directos')
                ->onDelete('cascade')
                ->comment('Costo directo al que pertenece el documento');
            
            // Datos del archivo
            $table->string('nombre_original', 255)->comment('Nombre original del archivo');
            $table->string('nombre_unico', 255)->comment('Nombre único almacenado');
            $table->string('ruta', 500)->comment('Ruta de almacenamiento');
            $table->string('tipo', 100)->comment('MIME type del archivo');
            $table->bigInteger('tamanio')->default(0)->comment('Tamaño en bytes');
            
            // Control
            $table->text('descripcion')->nullable()->comment('Descripción del documento');
            $table->integer('orden')->default(0)->comment('Orden de visualización');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('costo_directo_id');
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costos_directos_documentos');
    }
};