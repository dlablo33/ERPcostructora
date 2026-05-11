<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitudes_factoraje', function (Blueprint $table) {
            $table->id('solicitud_id');
            $table->string('folio', 20)->unique();
            $table->date('fecha_solicitud');
            $table->date('fecha_autorizacion')->nullable();
            $table->unsignedBigInteger('factor_id');
            $table->unsignedBigInteger('contacto_id'); // cliente dueño de la factura
            $table->decimal('monto_factura', 12, 2);
            $table->decimal('porcentaje_anticipo', 5, 2)->default(85.00);
            $table->decimal('monto_anticipo', 12, 2);
            $table->decimal('tasa_interes', 5, 2)->nullable();
            $table->decimal('comision', 12, 2)->nullable();
            $table->decimal('iva_comision', 12, 2)->nullable();
            $table->decimal('total_comision', 12, 2)->nullable();
            $table->decimal('monto_recibir', 12, 2); // Monto total que recibe la empresa
            $table->date('fecha_vencimiento_factoraje')->nullable();
            $table->date('fecha_liquidacion')->nullable();
            $table->integer('estatus')->default(1); // 1=Solicitado, 2=Autorizado, 3=Liquidado, 4=Rechazado, 5=Vencido
            $table->string('referencia_pago', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('autorizado_por')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('factor_id')->references('factor_id')->on('factores_financieros');
            $table->foreign('contacto_id')->references('contacto_id')->on('contactos');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('autorizado_por')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes_factoraje');
    }
};