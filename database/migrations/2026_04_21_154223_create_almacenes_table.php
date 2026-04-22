<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique(); // ALM-001, ALM-002, etc.
            $table->string('nombre', 100); // Nombre del almacén
            $table->string('tipo', 50); // General, Refrigerado, Materiales Peligrosos, etc.
            $table->text('descripcion')->nullable();
            $table->string('ubicacion', 255)->nullable(); // Dirección física
            $table->string('responsable', 100)->nullable(); // Persona responsable
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('cuenta_contable', 50)->nullable();
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('codigo');
            $table->index('tipo');
            $table->index('estatus');
        });
    }

    public function down()
    {
        Schema::dropIfExists('almacenes');
    }
};