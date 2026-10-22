<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (!Schema::hasColumn('facturas', 'descuento')) {
                $table->decimal('descuento', 15, 2)->default(0)->after('subtotal');
            }
            if (!Schema::hasColumn('facturas', 'retencion_iva')) {
                $table->decimal('retencion_iva', 15, 2)->default(0)->after('iva');
            }
            if (!Schema::hasColumn('facturas', 'retencion_isr')) {
                $table->decimal('retencion_isr', 15, 2)->default(0)->after('retencion_iva');
            }
            if (!Schema::hasColumn('facturas', 'retencion_garantia')) {
                $table->decimal('retencion_garantia', 15, 2)->default(0)->after('retencion_isr');
            }
            if (!Schema::hasColumn('facturas', 'factura_origen_id')) {
                $table->unsignedBigInteger('factura_origen_id')->nullable();
            }
            if (!Schema::hasColumn('facturas', 'nota_venta_id')) {
                $table->unsignedBigInteger('nota_venta_id')->nullable();
            }
            if (!Schema::hasColumn('facturas', 'nota_venta_folio')) {
                $table->string('nota_venta_folio', 50)->nullable();
            }
        });

        Schema::table('facturas_conceptos', function (Blueprint $table) {
            if (!Schema::hasColumn('facturas_conceptos', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('descripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn([
                'descuento',
                'retencion_iva',
                'retencion_isr',
                'retencion_garantia',
                'factura_origen_id',
                'nota_venta_id',
                'nota_venta_folio',
            ]);
        });

        Schema::table('facturas_conceptos', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
};