<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requisiciones_activos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 20)->unique();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('restrict');
            $table->foreignId('activo_id')->constrained('activos')->onDelete('restrict');
            $table->integer('cantidad')->default(1);
            $table->date('fecha_requisicion');
            $table->date('fecha_requerida');
            $table->date('fecha_estimada_devolucion')->nullable();
            $table->string('solicitante', 100);
            $table->string('area', 100)->nullable();
            $table->enum('prioridad', ['Baja', 'Media', 'Alta', 'Urgente'])->default('Media');
            $table->text('motivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estatus', ['Pendiente', 'Aprobada', 'Rechazada', 'Asignada', 'Devuelta', 'Cancelada'])->default('Pendiente');
            $table->foreignId('autorizado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_autorizacion')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('folio');
            $table->index('proyecto_id');
            $table->index('activo_id');
            $table->index('estatus');
            $table->index('fecha_requisicion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisiciones_activos');
    }
};