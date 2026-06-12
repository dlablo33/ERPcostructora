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
        Schema::create('movimientos_poliza', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poliza_contable_id');
            $table->unsignedBigInteger('cuenta_contable_id')->nullable();
            $table->decimal('debe', 15, 2)->default(0);
            $table->decimal('haber', 15, 2)->default(0);
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices y foreign keys
            $table->foreign('poliza_contable_id')
                  ->references('poliza_contable_id')
                  ->on('polizas_contables')
                  ->onDelete('restrict');
            
            $table->foreign('cuenta_contable_id')
                  ->references('id')
                  ->on('cuentas_contables')
                  ->onDelete('set null');
            
            $table->index('poliza_contable_id');
            $table->index('cuenta_contable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_poliza');
    }
};