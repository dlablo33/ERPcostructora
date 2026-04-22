<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activos_herramientas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activo_id')->constrained('activos')->onDelete('cascade');
            $table->string('tipo_herramienta', 100)->nullable();
            $table->string('voltaje', 50)->nullable();
            $table->decimal('potencia', 10, 2)->nullable();
            $table->boolean('requiere_calibracion')->default(false);
            $table->date('fecha_ultima_calibracion')->nullable();
            $table->date('fecha_proxima_calibracion')->nullable();
            $table->string('numero_inventario', 50)->nullable();
            $table->integer('prestamos_realizados')->default(0);
            $table->decimal('tiempo_uso_promedio', 8, 2)->nullable();
            $table->timestamps();
            
            $table->index('activo_id');
            $table->index('tipo_herramienta');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activos_herramientas');
    }
};