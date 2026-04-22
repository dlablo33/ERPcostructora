<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activos_maquinaria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activo_id')->constrained('activos')->onDelete('cascade');
            $table->decimal('horometro_actual', 12, 1)->default(0);
            $table->decimal('horometro_compra', 12, 1)->default(0);
            $table->decimal('horometro_ultimo_mantenimiento', 12, 1)->default(0);
            $table->decimal('horometro_proximo_mantenimiento', 12, 1)->nullable();
            $table->enum('tipo_combustible', ['Diesel', 'Gasolina', 'Electrico', 'Hibrido'])->nullable();
            $table->decimal('consumo_promedio', 8, 2)->nullable();
            $table->decimal('capacidad_tanque', 10, 2)->nullable();
            $table->decimal('peso_operativo', 10, 2)->nullable();
            $table->decimal('capacidad_carga', 10, 2)->nullable();
            $table->string('unidad_capacidad', 20)->nullable();
            $table->string('dimensiones', 100)->nullable();
            $table->foreignId('operador_actual_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('licencia_requerida', 50)->nullable();
            $table->date('ultimo_servicio_fecha')->nullable();
            $table->date('proximo_servicio_fecha')->nullable();
            $table->integer('mantenimiento_preventivo_dias')->nullable();
            $table->timestamps();
            
            $table->index('activo_id');
            $table->index('horometro_actual');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activos_maquinaria');
    }
};