<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyecto_costos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->decimal('materiales', 15, 2)->default(0);
            $table->decimal('mano_obra', 15, 2)->default(0);
            $table->decimal('maquinaria', 15, 2)->default(0);
            $table->decimal('gastos_indirectos', 15, 2)->default(0);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            
            // Índices
            $table->index('proyecto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_costos');
    }
};