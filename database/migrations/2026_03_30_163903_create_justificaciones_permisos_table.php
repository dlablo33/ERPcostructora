<?php

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
        Schema::create('justificaciones_permisos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->unique();
            $table->unsignedBigInteger('empleado_id');
            $table->string('empleado_nombre', 200);
            $table->string('tipo', 100);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('dias');
            $table->enum('estatus', ['Pendiente', 'Aprobado', 'Rechazado'])->default('Pendiente');
            $table->boolean('tiene_justificante')->default(false);
            $table->text('motivo')->nullable();
            $table->string('archivo_justificante', 255)->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('autorizado_por')->nullable();
            $table->timestamp('fecha_autorizacion')->nullable();
            $table->timestamps();
            
            // Índices
            $table->index('empleado_id');
            $table->index('folio');
            $table->index('estatus');
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('justificaciones_permisos');
    }
};