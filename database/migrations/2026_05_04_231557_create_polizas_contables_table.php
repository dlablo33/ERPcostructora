<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('polizas_contables', function (Blueprint $table) {
            $table->id('poliza_contable_id');
            $table->string('folio', 30)->unique();
            $table->date('fecha');
            $table->string('origen', 50);
            $table->unsignedBigInteger('origen_id')->nullable(); // ID de factura, pago, etc.
            $table->decimal('total_debe', 14, 2);
            $table->decimal('total_haber', 14, 2);
            $table->string('descripcion')->nullable();
            $table->enum('tipo', ['diario', 'ingreso', 'egreso'])->default('diario');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Tabla de movimientos de póliza
        Schema::create('polizas_movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poliza_contable_id');
            $table->unsignedBigInteger('cuenta_contable_id');
            $table->decimal('debe', 14, 2)->default(0);
            $table->decimal('haber', 14, 2)->default(0);
            $table->string('descripcion')->nullable();
            $table->timestamps();
            
            $table->foreign('poliza_contable_id')->references('poliza_contable_id')->on('polizas_contables')->onDelete('cascade');
            $table->foreign('cuenta_contable_id')->references('id')->on('cuentas_contables');
        });
    }

    public function down()
    {
        Schema::dropIfExists('polizas_movimientos');
        Schema::dropIfExists('polizas_contables');
    }
};