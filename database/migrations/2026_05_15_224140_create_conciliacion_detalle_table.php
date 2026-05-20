<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conciliacion_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conciliacion_id')->constrained('conciliacion_bancaria')->onDelete('cascade');
            $table->enum('origen', ['Sistema', 'Extracto']);
            $table->date('fecha');
            $table->string('descripcion', 255);
            $table->string('referencia', 100)->nullable();
            $table->decimal('egreso', 14, 2)->default(0);
            $table->decimal('ingreso', 14, 2)->default(0);
            $table->string('numero_transaccion', 50)->nullable();
            $table->enum('estatus', ['Pendiente', 'Conciliado', 'Diferencia'])->default('Pendiente');
            $table->foreignId('conciliado_con')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conciliacion_detalle');
    }
};