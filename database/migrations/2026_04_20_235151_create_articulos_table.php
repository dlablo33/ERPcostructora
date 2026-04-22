<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('descripcion', 500);
            $table->string('numero_parte', 100)->nullable();
            $table->foreignId('familia_id')->nullable()->constrained('familias')->onDelete('set null');
            $table->foreignId('subfamilia_id')->nullable()->constrained('subfamilias')->onDelete('set null');
            $table->string('ubicacion', 50)->nullable();
            $table->decimal('minimo', 12, 3)->default(0);
            $table->decimal('maximo', 12, 3)->default(0);
            $table->decimal('punto_reorden', 12, 3)->default(0);
            $table->string('unidad_medida', 20)->nullable();
            $table->string('cuenta_contable', 50)->nullable();
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('codigo');
            $table->index('familia_id');
            $table->index('subfamilia_id');
            $table->index('estatus');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articulos');
    }
};