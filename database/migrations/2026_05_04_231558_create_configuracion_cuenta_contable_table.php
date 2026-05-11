<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracion_cuenta_contable', function (Blueprint $table) {
            $table->id('configuracion_cuenta_contable_id');
            $table->string('categoria', 50); // ejemplo: 'ventas', 'iva', 'retenciones'
            $table->unsignedBigInteger('cuenta_contable_id');
            $table->enum('tipo', ['cargo', 'abono']); // 1 = cargo, 2 = abono (pero usamos string)
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->foreign('cuenta_contable_id')->references('id')->on('cuentas_contables');
            $table->unique(['categoria', 'cuenta_contable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracion_cuenta_contable');
    }
};