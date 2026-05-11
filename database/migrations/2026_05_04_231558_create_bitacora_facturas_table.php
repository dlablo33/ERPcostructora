<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bitacora_facturas', function (Blueprint $table) {
            $table->id('bitacora_factura_id');
            $table->unsignedBigInteger('factura_id');
            $table->string('comentario');
            $table->unsignedBigInteger('__userId__');
            $table->timestamps();
            
            $table->foreign('factura_id')->references('factura_id')->on('facturas')->onDelete('cascade');
            $table->foreign('__userId__')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bitacora_facturas');
    }
};