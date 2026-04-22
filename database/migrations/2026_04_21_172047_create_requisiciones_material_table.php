<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requisiciones_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('restrict');
            $table->string('folio', 20)->unique();
            $table->date('fecha_requisicion');
            $table->string('solicitante', 100);
            $table->string('area', 100)->nullable();
            $table->enum('prioridad', ['Alta', 'Media', 'Baja'])->default('Media');
            $table->enum('estatus', ['Pendiente', 'Autorizada', 'Rechazada', 'Surtida', 'Cancelada'])->default('Pendiente');
            $table->foreignId('autorizado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_autorizacion')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('proyecto_id');
            $table->index('folio');
            $table->index('estatus');
            $table->index('fecha_requisicion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisiciones_material');
    }
};