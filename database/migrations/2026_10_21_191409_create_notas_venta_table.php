<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('notas_venta')) {
            return;
        }

        Schema::create('notas_venta', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->unique();
            $table->date('fecha');
            $table->unsignedBigInteger('contacto_id')->nullable();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->unsignedBigInteger('cat_serie_id')->nullable();

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('iva', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);

            // Estatus: 1 = abierta, 19 = facturada, 21 = cancelada
            $table->integer('estatus')->default(1);

            // Vínculo con factura
            $table->boolean('facturada')->default(false);
            $table->unsignedBigInteger('factura_id')->nullable();

            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('contacto_id');
            $table->index('proyecto_id');
            $table->index('facturada');
            $table->index('estatus');
            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas_venta');
    }
};