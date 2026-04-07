<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_listas_asistencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lista_asistencia_id');
            $table->unsignedBigInteger('empleado_id');
            $table->string('empleado_nombre', 200);
            $table->string('puesto', 100)->nullable();
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->enum('estado', ['presente', 'retardo', 'ausente', 'justificado'])->default('ausente');
            $table->text('observaciones')->nullable();
            $table->decimal('horas_trabajadas', 5, 2)->default(0);
            $table->boolean('justificado')->default(false);
            $table->unsignedBigInteger('justificacion_id')->nullable();
            $table->timestamps();
            
            $table->foreign('lista_asistencia_id')->references('id')->on('listas_asistencia')->onDelete('cascade');
            $table->foreign('empleado_id')->references('plantilla_id')->on('plantillas')->onDelete('cascade');
            $table->foreign('justificacion_id')->references('id')->on('justificaciones_permisos')->onDelete('set null');
            
            $table->index('lista_asistencia_id');
            $table->index('empleado_id');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_listas_asistencia');
    }
};