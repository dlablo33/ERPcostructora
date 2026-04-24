<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cotizacion_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->foreignId('articulo_id')->constrained('articulos');
            $table->decimal('cantidad', 15, 3);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('impuestos', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->text('observacion')->nullable();
            $table->timestamps();
            
            $table->index('cotizacion_id');
            $table->unique(['cotizacion_id', 'articulo_id'], 'uniq_cotizacion_articulo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cotizacion_detalles');
    }
};