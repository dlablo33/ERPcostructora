<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisicion_id')->constrained('requisiciones')->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->string('folio')->unique();
            $table->date('fecha_cotizacion');
            $table->integer('tiempo_entrega_dias')->nullable();
            $table->string('condiciones_pago', 100)->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('impuestos', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('archivo_pdf')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estatus', ['Pendiente', 'Seleccionada', 'Rechazada'])->default('Pendiente');
            $table->foreignId('creado_por')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['requisicion_id', 'proveedor_id']);
            $table->index('estatus');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
};