<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finiquitos', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('plantilla_id')->constrained('plantillas', 'plantilla_id')->onDelete('restrict');
            $table->string('tipo'); // finiquito, liquidacion
            $table->date('fecha_baja');
            $table->date('fecha_ingreso');
            $table->decimal('salario_diario', 12, 2);
            $table->decimal('salario_integrado', 12, 2);
            $table->integer('dias_vacaciones')->default(0);
            $table->decimal('prima_vacacional', 12, 2)->default(0);
            $table->decimal('aguinaldo', 12, 2)->default(0);
            $table->decimal('indemnizacion', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('estatus')->default('Pendiente'); // Pendiente, Autorizado, Pagado, Cancelado
            $table->text('observaciones')->nullable();
            $table->string('motivo_baja')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('usuario_autorizo')->nullable();
            $table->datetime('fecha_autorizacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finiquitos');
    }
};