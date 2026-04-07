<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyecto_flujo_efectivo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->integer('mes');
            $table->decimal('ingreso_estimado', 15, 2)->default(0);
            $table->decimal('gasto_estimado', 15, 2)->default(0);
            $table->decimal('flujo_neto', 15, 2)->default(0);
            $table->decimal('saldo_acumulado', 15, 2)->default(0);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            
            // Índices
            $table->index('proyecto_id');
            $table->unique(['proyecto_id', 'mes']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_flujo_efectivo');
    }
};