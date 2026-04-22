<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventario_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('restrict');
            $table->foreignId('articulo_id')->constrained('articulos')->onDelete('restrict');
            $table->decimal('cantidad_actual', 12, 3)->default(0);
            $table->decimal('cantidad_reservada', 12, 3)->default(0);
            $table->decimal('cantidad_minima', 12, 3)->default(0);
            $table->decimal('cantidad_maxima', 12, 3)->default(0);
            $table->decimal('punto_reorden', 12, 3)->default(0);
            $table->string('unidad_medida', 20)->nullable();
            $table->timestamp('ultima_entrada')->nullable();
            $table->timestamp('ultima_salida')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['proyecto_id', 'articulo_id']);
            $table->index('proyecto_id');
            $table->index('articulo_id');
            $table->index('estatus');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventario_proyecto');
    }
};