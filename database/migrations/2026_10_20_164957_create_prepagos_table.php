<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prepagos', function (Blueprint $table) {
            $table->id();

            // Folio único autogenerado (ej. PRE-2026-000001)
            $table->string('folio', 50)->unique()->nullable();

            // Relación con proveedor
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')
                  ->references('id')
                  ->on('proveedores')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Datos del prepago
            $table->date('fecha');
            $table->decimal('monto', 15, 2);
            $table->text('observaciones')->nullable();

            // Estatus del prepago
            $table->enum('estatus', ['activo', 'aplicado', 'cancelado'])
                  ->default('activo');

            // Usuario que lo registró
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Índices para búsquedas frecuentes
            $table->index('fecha');
            $table->index('estatus');
            $table->index(['proveedor_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prepagos');
    }
};