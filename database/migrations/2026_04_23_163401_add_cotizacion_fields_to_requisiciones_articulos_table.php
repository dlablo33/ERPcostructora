<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requisicion_articulos', function (Blueprint $table) {
            $table->foreignId('cotizacion_seleccionada_id')->nullable()->constrained('cotizaciones_articulos')->onDelete('set null');
            $table->foreignId('proveedor_seleccionado_id')->nullable()->constrained('proveedores');
            $table->decimal('precio_unitario_seleccionado', 15, 2)->nullable();
            $table->integer('tiempo_entrega_seleccionado')->nullable();
            $table->string('condiciones_pago_seleccionado', 100)->nullable();
            $table->boolean('cotizada')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('requisicion_articulos', function (Blueprint $table) {
            $table->dropForeign(['cotizacion_seleccionada_id']);
            $table->dropForeign(['proveedor_seleccionado_id']);
            $table->dropColumn([
                'cotizacion_seleccionada_id',
                'proveedor_seleccionado_id',
                'precio_unitario_seleccionado',
                'tiempo_entrega_seleccionado',
                'condiciones_pago_seleccionado',
                'cotizada'
            ]);
        });
    }
};