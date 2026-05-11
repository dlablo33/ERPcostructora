<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contrarecibo_facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrarecibo_id');
            $table->unsignedBigInteger('factura_id');
            $table->decimal('monto_aplicado', 12, 2);
            $table->timestamps();
            
            $table->foreign('contrarecibo_id')->references('contrarecibo_id')->on('contrarecibos')->onDelete('cascade');
            $table->foreign('factura_id')->references('factura_id')->on('facturas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contrarecibo_facturas');
    }
};