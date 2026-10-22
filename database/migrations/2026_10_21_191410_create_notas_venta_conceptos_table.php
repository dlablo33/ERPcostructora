<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('notas_venta_conceptos')) {
            return;
        }

        Schema::create('notas_venta_conceptos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_venta_id');

            $table->string('codigo', 50)->nullable();
            $table->string('descripcion');
            $table->decimal('cantidad', 15, 4)->default(1);
            $table->decimal('valor_unitario', 15, 2)->default(0);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('importe', 15, 2)->default(0);
            $table->decimal('iva', 15, 2)->default(0);

            $table->string('satcat_clave_productos_clave', 20)->nullable();
            $table->string('satcat_unidades_clave', 10)->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->foreign('nota_venta_id')
                  ->references('id')->on('notas_venta')
                  ->onDelete('cascade');

            $table->index('nota_venta_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas_venta_conceptos');
    }
};