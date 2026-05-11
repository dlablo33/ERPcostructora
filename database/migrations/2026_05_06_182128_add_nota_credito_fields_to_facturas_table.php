<?php
// database/migrations/2026_05_06_000001_add_nota_credito_fields_to_facturas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            // Campo para relacionar con la factura original
            $table->bigInteger('factura_relacionada_id')->nullable()->after('id');
            $table->foreign('factura_relacionada_id')->references('factura_id')->on('facturas')->onDelete('set null');
            
            // Tipo de comprobante: I = Ingreso (Factura), E = Egreso (Nota de Crédito)
            $table->string('tipo_comprobante', 2)->default('I')->after('folio');
            
            // Motivo de la nota de crédito
            $table->text('motivo_nota_credito')->nullable()->after('observaciones');
            
            // Índices para búsquedas rápidas
            $table->index('tipo_comprobante');
            $table->index('factura_relacionada_id');
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropForeign(['factura_relacionada_id']);
            $table->dropColumn(['factura_relacionada_id', 'tipo_comprobante', 'motivo_nota_credito']);
        });
    }
};