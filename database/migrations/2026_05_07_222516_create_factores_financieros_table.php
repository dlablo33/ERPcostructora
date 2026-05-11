<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factores_financieros', function (Blueprint $table) {
            $table->id('factor_id');
            $table->string('nombre', 150);
            $table->string('rfc', 13);
            $table->string('contacto_nombre', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->decimal('porcentaje_anticipo_default', 5, 2)->default(85.00);
            $table->decimal('comision_default', 5, 2)->default(3.00);
            $table->integer('dias_plazo_default')->default(30);
            $table->boolean('activo')->default(true);
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factores_financieros');
    }
};