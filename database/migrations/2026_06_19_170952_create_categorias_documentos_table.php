<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_documentos', function (Blueprint $table) {
            $table->id();
            
            $table->string('codigo', 20)->unique()->comment('Código de la categoría');
            $table->string('nombre', 100)->comment('Nombre de la categoría');
            $table->string('tipo', 20)->comment('contrato, plano, general');
            $table->text('descripcion')->nullable()->comment('Descripción de la categoría');
            
            $table->boolean('activo')->default(true);
            
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categorias_documentos')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->comment('Categoría padre');
            
            $table->integer('orden')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('tipo');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_documentos');
    }
};