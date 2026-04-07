<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomina', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->unique();
            $table->unsignedBigInteger('empleado_id');
            $table->string('empleado_nombre', 200);
            $table->string('puesto', 100)->nullable();
            
            // Período
            $table->enum('periodo_tipo', ['semanal', 'quincenal'])->default('quincenal');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->integer('dias_trabajados')->default(0);
            $table->integer('dias_ausentes')->default(0);
            $table->integer('dias_retardo')->default(0);
            $table->integer('dias_justificados')->default(0);
            
            // Sueldos y salarios
            $table->decimal('sueldo_diario', 10, 2)->default(0);
            $table->decimal('sueldo_periodo', 10, 2)->default(0);
            
            // Percepciones
            $table->decimal('sueldo_base', 10, 2)->default(0);
            $table->decimal('bono_asistencia', 10, 2)->default(0);
            $table->decimal('bono_productividad', 10, 2)->default(0);
            $table->decimal('horas_extras', 10, 2)->default(0);
            $table->decimal('prima_vacacional', 10, 2)->default(0);
            $table->decimal('aguinaldo_proporcional', 10, 2)->default(0);
            $table->decimal('otras_percepciones', 10, 2)->default(0);
            $table->decimal('total_percepciones', 10, 2)->default(0);
            
            // Deducciones
            $table->decimal('isr', 10, 2)->default(0);
            $table->decimal('imss', 10, 2)->default(0);
            $table->decimal('infonavit', 10, 2)->default(0);
            $table->decimal('fonacot', 10, 2)->default(0);
            $table->decimal('pension_alimenticia', 10, 2)->default(0);
            $table->decimal('prestamos', 10, 2)->default(0);
            $table->decimal('faltas', 10, 2)->default(0);
            $table->decimal('retardos_multa', 10, 2)->default(0);
            $table->decimal('otras_deducciones', 10, 2)->default(0);
            $table->decimal('total_deducciones', 10, 2)->default(0);
            
            // Totales
            $table->decimal('neto_pagar', 10, 2)->default(0);
            
            // Estado
            $table->enum('estatus', ['Pendiente', 'Calculada', 'Pagada', 'Cancelada'])->default('Pendiente');
            $table->date('fecha_pago')->nullable();
            $table->text('observaciones')->nullable();
            
            $table->unsignedBigInteger('calculado_por')->nullable();
            $table->timestamps();
            
            $table->index('empleado_id');
            $table->index('periodo_inicio');
            $table->index('periodo_fin');
            $table->index('estatus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomina');
    }
};