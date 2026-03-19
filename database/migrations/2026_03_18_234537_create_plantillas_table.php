<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id('plantilla_id');
            $table->string('nombre');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('correo')->nullable();
            $table->string('celular')->nullable();
            $table->string('numero_seguro_social')->nullable();
            $table->string('rfc', 20)->nullable();
            $table->string('curp', 20)->nullable();
            $table->string('alias')->nullable();
            $table->string('calle')->nullable();
            $table->string('num_exterior', 20)->nullable();
            $table->string('num_interior', 20)->nullable();
            $table->string('satcat_paises_clave', 10)->nullable();
            $table->string('satcat_codigos_postales_codigo_postal', 10)->nullable();
            $table->string('satcat_estados_clave', 10)->nullable();
            $table->string('satcat_municipios_clave', 10)->nullable();
            $table->string('satcat_colonias_clave', 10)->nullable();
            $table->string('satcat_localidades_clave', 10)->nullable();
            $table->unsignedBigInteger('cat_area_id')->nullable();
            $table->unsignedBigInteger('cat_puesto_id')->nullable();
            $table->decimal('sueldo', 10, 2)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('reclutador')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->unsignedBigInteger('motivo_baja_id')->nullable();
            $table->boolean('operador')->default(false);
            $table->unsignedBigInteger('cat_tipo_operador_id')->nullable();
            $table->unsignedBigInteger('cat_tipo_licencia_id')->nullable();
            $table->string('numero_licencia')->nullable();
            $table->string('licencia_reconocimiento')->nullable();
            $table->string('contacto_emergencia')->nullable();
            $table->string('numero_emergencia')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->boolean('borrado_logico')->default(false);
            $table->string('estatus', 50)->default('Activo');
            $table->date('vencimiento_licencia')->nullable();
            $table->unsignedBigInteger('cat_tipo_cuenta_id')->nullable();
            $table->string('cuenta')->nullable();
            $table->string('propietario')->nullable();
            $table->string('municipio')->nullable();
            $table->string('estado')->nullable();
            $table->string('satcat_figura_transporte_clave', 10)->nullable();
            $table->string('cat_bancos_clave', 10)->nullable();
            $table->string('cuenta_sucursal')->nullable();
            $table->decimal('monto_mensual_imss', 10, 2)->nullable();
            $table->decimal('monto_diario_imss', 10, 2)->nullable();
            $table->decimal('monto_mensual_infonavit', 10, 2)->nullable();
            $table->decimal('monto_diario_infonavit', 10, 2)->nullable();
            $table->decimal('monto_mensual_isr', 10, 2)->nullable();
            $table->decimal('monto_diario_isr', 10, 2)->nullable();
            $table->decimal('sueldo_hora', 10, 2)->nullable();
            $table->string('numero_medicina_preventiva')->nullable();
            $table->string('satcat_colonias_claveopen', 10)->nullable();
            $table->unsignedBigInteger('cuenta_contable_sat_id')->nullable();
            $table->integer('dias_vacaciones')->nullable();
            $table->decimal('prima_vacacional', 5, 2)->nullable();
            $table->integer('aguinaldo')->nullable();
            $table->decimal('sueldo_diario', 10, 2)->nullable();
            $table->decimal('sueldo_integrado', 10, 2)->nullable();
            $table->string('satcat_nomina_contratos_clave', 10)->nullable();
            $table->string('satcat_nomina_jornadas_clave', 10)->nullable();
            $table->string('satcat_nomina_periodicidades_clave', 10)->nullable();
            $table->string('satcat_nomina_regimenes_clave', 10)->nullable();
            $table->string('propietario_tipo')->nullable();
            $table->string('razon_social')->nullable();
            $table->unsignedBigInteger('datos_generales_id')->nullable();
            $table->string('estatus_seguro_social', 50)->nullable();
            $table->boolean('bono_asistencia')->default(false);
            $table->boolean('bono_productividad')->default(false);
            $table->decimal('sueldo_canacar', 10, 2)->nullable();
            $table->boolean('pension_alimenticia')->default(false);
            $table->boolean('reserva')->default(false);
            $table->string('numero_empleado_interno')->nullable();
            $table->boolean('bono_federal')->default(false);
            $table->boolean('bono_administrativo')->default(false);
            $table->boolean('aplica_asistencia')->default(false);
            $table->boolean('fonacot')->default(false);
            $table->json('nomina_percepciones')->nullable();
            $table->json('nomina_deducciones')->nullable();
            $table->json('nomina_otros_pagos')->nullable();
            $table->decimal('nomina_total', 10, 2)->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('coordinador_plantilla_id')->nullable();
            $table->unsignedBigInteger('__userId__')->nullable();
            $table->boolean('pagar_por_liquidacion')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('rfc');
            $table->index('curp');
            $table->index('numero_empleado_interno');
            $table->index('cat_area_id');
            $table->index('cat_puesto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantillas');
    }
};