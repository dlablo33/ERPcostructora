<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asignaciones_activos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisicion_id')->nullable()->constrained('requisiciones_activos')->onDelete('set null');
            $table->foreignId('activo_id')->constrained('activos')->onDelete('restrict');
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('restrict');
            $table->string('responsable_asignado', 100);
            $table->date('fecha_salida');
            $table->date('fecha_devolucion_real')->nullable();
            $table->decimal('horometro_salida', 12, 1)->nullable();
            $table->decimal('horometro_devolucion', 12, 1)->nullable();
            $table->decimal('kilometraje_salida', 12, 1)->nullable();
            $table->decimal('kilometraje_devolucion', 12, 1)->nullable();
            $table->enum('condicion_salida', ['Excelente', 'Bueno', 'Regular', 'Malo'])->default('Bueno');
            $table->enum('condicion_devolucion', ['Excelente', 'Bueno', 'Regular', 'Malo', 'Danado'])->nullable();
            $table->text('observaciones_salida')->nullable();
            $table->text('observaciones_devolucion')->nullable();
            $table->text('reporte_danos')->nullable();
            $table->decimal('costo_reparacion', 12, 2)->nullable();
            $table->enum('estatus', ['Activa', 'Devuelta', 'Parcial'])->default('Activa');
            $table->foreignId('recibido_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('requisicion_id');
            $table->index('activo_id');
            $table->index('proyecto_id');
            $table->index('estatus');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asignaciones_activos');
    }
};