<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listas_asistencia', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->unique();
            $table->date('fecha');
            $table->integer('total_empleados')->default(0);
            $table->integer('presentes')->default(0);
            $table->integer('retardos')->default(0);
            $table->integer('ausentes')->default(0);
            $table->integer('justificados')->default(0);
            $table->boolean('cerrada')->default(false);
            $table->timestamp('fecha_cierre')->nullable();
            $table->text('observaciones_generales')->nullable();
            $table->unsignedBigInteger('creado_por')->nullable();
            $table->timestamps();
            
            $table->index('folio');
            $table->index('fecha');
            $table->index('cerrada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listas_asistencia');
    }
};