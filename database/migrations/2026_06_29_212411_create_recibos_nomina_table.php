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
        Schema::create('recibos_nomina', function (Blueprint $table) {
            $table->id();
            
            // Datos del recibo
            $table->string('folio', 30)->unique();
            $table->unsignedBigInteger('nomina_id')->nullable();
            $table->unsignedBigInteger('empleado_id');
            
            // Datos del empleado
            $table->string('empleado_nombre', 200);
            $table->string('rfc', 20);
            $table->string('curp', 20)->nullable();
            $table->string('nss', 20)->nullable();
            $table->string('puesto', 100)->nullable();
            $table->string('area', 100)->nullable();
            
            // Período
            $table->string('periodo', 50);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_pago');
            $table->integer('dias_pagados')->default(0);
            
            // Montos
            $table->decimal('total_percepciones', 15, 2)->default(0);
            $table->decimal('total_deducciones', 15, 2)->default(0);
            $table->decimal('neto_pagar', 15, 2)->default(0);
            
            // Datos de timbrado
            $table->string('uuid', 50)->nullable()->unique();
            $table->string('estatus_timbrado', 30)->default('Por Timbrar');
            $table->timestamp('fecha_timbrado')->nullable();
            $table->text('sello_cfd')->nullable();
            $table->text('sello_sat')->nullable();
            $table->string('no_certificado_sat', 50)->nullable();
            $table->text('cadena_original')->nullable();
            
            // Archivos
            $table->string('pdf_path', 500)->nullable();
            $table->string('xml_path', 500)->nullable();
            
            // Datos de la empresa
            $table->string('empresa_razon_social', 200)->nullable();
            $table->string('empresa_rfc', 20)->nullable();
            $table->string('empresa_regimen_fiscal', 100)->nullable();
            
            // Auditoría
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('timbrado_por')->nullable();
            $table->unsignedBigInteger('cancelado_por')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('nomina_id');
            $table->index('empleado_id');
            $table->index('folio');
            $table->index('uuid');
            $table->index('estatus_timbrado');
            $table->index('fecha_pago');
            $table->index('fecha_timbrado');
            $table->index('periodo');
            $table->index('rfc');
            
            // Llaves foráneas
            $table->foreign('nomina_id')
                  ->references('id')
                  ->on('nomina')
                  ->onDelete('set null');
            
            $table->foreign('empleado_id')
                  ->references('plantilla_id')
                  ->on('plantillas')
                  ->onDelete('cascade');
            
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            $table->foreign('timbrado_por')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            $table->foreign('cancelado_por')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos_nomina');
    }
};