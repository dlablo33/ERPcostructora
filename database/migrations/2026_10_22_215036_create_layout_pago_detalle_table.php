<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layout_pago_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layout_pago_id')->constrained('layouts_pago')->cascadeOnDelete();
            $table->foreignId('pago_id')->nullable()->constrained('pagos')->nullOnDelete();
            $table->string('programacion', 20)->nullable();
            $table->string('referencia', 100)->nullable();
            $table->date('fecha');
            $table->string('proveedor_nombre', 200);
            $table->decimal('monto', 14, 2);
            $table->string('banco', 100)->nullable();
            $table->string('estatus', 30)->default('PROCESO COMPLETO');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layout_pago_detalle');
    }
};