<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos_activos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activo_id')->constrained('activos')->onDelete('restrict');
            $table->enum('tipo_movimiento', ['Prestamo', 'Devolucion', 'Mantenimiento', 'Transferencia', 'Baja']);
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->foreignId('proyecto_origen_id')->nullable()->constrained('proyectos')->onDelete('set null');
            $table->foreignId('proyecto_destino_id')->nullable()->constrained('proyectos')->onDelete('set null');
            $table->string('responsable_origen', 100)->nullable();
            $table->string('responsable_destino', 100)->nullable();
            $table->decimal('horometro_km', 12, 1)->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('activo_id');
            $table->index('tipo_movimiento');
            $table->index('fecha_movimiento');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_activos');
    }
};