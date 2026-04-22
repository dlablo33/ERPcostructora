<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventario_almacen_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventario_proyecto_id')->constrained('inventario_proyecto')->onDelete('cascade');
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('restrict');
            $table->decimal('cantidad', 12, 3)->default(0);
            $table->string('ubicacion_especifica', 100)->nullable();
            $table->string('lote', 50)->nullable();
            $table->date('fecha_caducidad')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index('inventario_proyecto_id');
            $table->index('almacen_id');
            $table->index('lote');
            $table->unique(['inventario_proyecto_id', 'almacen_id', 'lote'], 'inv_almacen_lote_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventario_almacen_proyecto');
    }
};