<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (!Schema::hasColumn('facturas', 'tipo_factura')) {
                $table->string('tipo_factura', 20)
                    ->default('cliente')
                    ->after('tipo_comprobante');
                $table->index('tipo_factura', 'idx_facturas_tipo_factura');
            }
        });

        // Retroactivo: marcar como cliente las facturas existentes que no sean de proveedor.
        // Si ya sabes cómo identificar las de proveedor, ajusta este where.
        DB::table('facturas')
            ->whereNull('tipo_factura')
            ->update(['tipo_factura' => 'cliente']);
    }

    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (Schema::hasColumn('facturas', 'tipo_factura')) {
                $table->dropIndex('idx_facturas_tipo_factura');
                $table->dropColumn('tipo_factura');
            }
        });
    }
};