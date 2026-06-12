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
        Schema::create('complementos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50);
            $table->unsignedBigInteger('cliente_id');
            $table->string('rfc', 13)->nullable();
            $table->date('fecha_pago');
            $table->string('documento_relacionado', 50)->nullable();
            $table->string('forma_pago', 50)->nullable();
            $table->decimal('monto', 15, 2);
            $table->string('estatus', 20)->default('Pendiente');
            $table->string('uuid', 36)->nullable();
            $table->unsignedBigInteger('cfdi_id')->nullable();
            $table->unsignedBigInteger('poliza_contable_id')->nullable();
            $table->unsignedBigInteger('pago_id')->nullable();
            $table->unsignedBigInteger('contrarecibo_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('cliente_id')
                  ->references('contacto_id')
                  ->on('contactos')
                  ->onDelete('restrict');
            
            $table->foreign('cfdi_id')
                  ->references('cfdi_id')
                  ->on('cfdi')
                  ->onDelete('set null');
            
            $table->foreign('poliza_contable_id')
                  ->references('poliza_contable_id')
                  ->on('polizas_contables')
                  ->onDelete('set null');
            
            $table->foreign('pago_id')
                  ->references('id')
                  ->on('pagos')
                  ->onDelete('set null');
            
            $table->foreign('contrarecibo_id')
                  ->references('contrarecibo_id')
                  ->on('contrarecibos')
                  ->onDelete('set null');
            
            // Índices para mejorar rendimiento
            $table->index('folio');
            $table->index('cliente_id');
            $table->index('fecha_pago');
            $table->index('estatus');
            $table->index('uuid');
            $table->index('documento_relacionado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complementos_pago');
    }
};