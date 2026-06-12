<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gastos_indirectos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50);
            $table->date('fecha');
            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->decimal('monto', 15, 2);
            $table->string('partida', 50)->nullable();
            $table->string('tipo_documento', 50)->nullable();
            $table->string('forma_pago', 50)->nullable();
            $table->text('concepto')->nullable();
            $table->unsignedBigInteger('tipo_gasto_id')->nullable();
            $table->unsignedBigInteger('poliza_contable_id')->nullable();
            $table->string('estatus', 20)->default('activo');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('proyecto_id')
                  ->references('id')
                  ->on('proyectos')
                  ->onDelete('restrict');
            
            $table->foreign('proveedor_id')
                  ->references('id')
                  ->on('proveedores')
                  ->onDelete('set null');
            
            $table->foreign('poliza_contable_id')
                  ->references('poliza_contable_id')
                  ->on('polizas_contables')
                  ->onDelete('set null');
            
            // Índices para mejorar rendimiento
            $table->index('proyecto_id');
            $table->index('fecha');
            $table->index('folio');
            $table->index('tipo_gasto_id');
            $table->index('estatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos_indirectos');
    }
}; 