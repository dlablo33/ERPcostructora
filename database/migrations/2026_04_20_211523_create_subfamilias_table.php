<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subfamilias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique(); // SUB-001, SUB-002, etc.
            $table->foreignId('familia_id')->constrained('familias')->onDelete('restrict');
            $table->string('nombre', 100); // Tipo Subfamilia: Eléctricas, Manuales, etc.
            $table->text('descripcion')->nullable();
            $table->string('cuenta_contable', 50)->nullable();
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('codigo');
            $table->index('familia_id');
            $table->index('estatus');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subfamilias');
    }
};