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
        Schema::create('presupuesto_mensual', function (Blueprint $table) {
            $table->id('presupuesto_mensual_id');
            $table->tinyInteger('mes')->unsigned()->comment('1=Enero ... 12=Diciembre');
            $table->smallInteger('anio')->unsigned();
            $table->decimal('monto', 15, 2)->default(0);
            $table->string('observaciones', 500)->nullable();
            $table->timestamps();

            // Índice único: no puede haber dos presupuestos para el mismo mes/año
            $table->unique(['mes', 'anio'], 'uk_presupuesto_mes_anio');

            // Índice para consultas por año/mes
            $table->index(['anio', 'mes'], 'idx_presupuesto_anio_mes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuesto_mensual');
    }
};