<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('familias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique(); // FAM-001, FAM-002, etc.
            $table->string('nombre', 100); // Tipo: Herramientas, Materiales, etc.
            $table->text('descripcion')->nullable();
            $table->string('cuenta_contable', 50)->nullable();
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('codigo');
            $table->index('estatus');
        });
    }

    public function down()
    {
        Schema::dropIfExists('familias');
    }
};