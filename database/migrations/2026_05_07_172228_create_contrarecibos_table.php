<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contrarecibos', function (Blueprint $table) {
            $table->id('contrarecibo_id');
            $table->string('folio', 20);
            $table->string('serie', 10)->default('CR');
            $table->date('fecha_pago');
            $table->unsignedBigInteger('contacto_id');
            $table->decimal('monto', 12, 2);
            $table->decimal('saldo_aplicado', 12, 2)->default(0);
            $table->string('forma_pago', 20)->nullable();
            $table->string('referencia_bancaria', 100)->nullable();
            $table->string('cuenta_origen', 50)->nullable();
            $table->string('cuenta_destino', 50)->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('estatus')->default(1); // 1=Pendiente, 19=Aplicado, 21=Cancelado
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('contacto_id')->references('contacto_id')->on('contactos');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contrarecibos');
    }
};