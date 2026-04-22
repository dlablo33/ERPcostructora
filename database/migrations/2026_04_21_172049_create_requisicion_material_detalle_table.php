<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requisicion_material_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisicion_id')->constrained('requisiciones_material')->onDelete('cascade');
            $table->foreignId('articulo_id')->constrained('articulos')->onDelete('restrict');
            $table->decimal('cantidad_solicitada', 12, 3);
            $table->decimal('cantidad_autorizada', 12, 3)->default(0);
            $table->decimal('cantidad_surtida', 12, 3)->default(0);
            $table->string('unidad_medida', 20)->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
            
            $table->index('requisicion_id');
            $table->index('articulo_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisicion_material_detalle');
    }
};