<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activos_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activo_id')->constrained('activos')->onDelete('cascade');
            $table->string('placas', 20)->unique();
            $table->string('numero_economico', 50)->nullable();
            $table->string('vin', 50)->nullable();
            $table->decimal('kilometraje_actual', 12, 1)->default(0);
            $table->decimal('kilometraje_compra', 12, 1)->default(0);
            $table->decimal('kilometraje_ultimo_mantenimiento', 12, 1)->default(0);
            $table->decimal('kilometraje_proximo_mantenimiento', 12, 1)->nullable();
            $table->enum('tipo_combustible', ['Diesel', 'Gasolina', 'Electrico', 'Hibrido'])->nullable();
            $table->decimal('consumo_promedio', 8, 2)->nullable();
            $table->decimal('capacidad_tanque', 10, 2)->nullable();
            $table->integer('capacidad_pasajeros')->nullable();
            $table->decimal('capacidad_carga', 10, 2)->nullable();
            $table->string('tipo_vehiculo', 50)->nullable();
            $table->string('traccion', 10)->nullable();
            $table->string('transmision', 20)->nullable();
            $table->string('poliza_seguro', 100)->nullable();
            $table->date('vencimiento_seguro')->nullable();
            $table->string('poliza_verificacion', 100)->nullable();
            $table->date('vencimiento_verificacion')->nullable();
            $table->date('ultimo_servicio_fecha')->nullable();
            $table->date('proximo_servicio_fecha')->nullable();
            $table->string('licencia_requerida', 50)->nullable();
            $table->timestamps();
            
            $table->index('activo_id');
            $table->index('placas');
            $table->index('kilometraje_actual');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activos_vehiculos');
    }
};