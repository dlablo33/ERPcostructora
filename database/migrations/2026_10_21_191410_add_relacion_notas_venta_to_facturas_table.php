<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (!Schema::hasColumn('facturas', 'nota_venta_id')) {
                $table->unsignedBigInteger('nota_venta_id')->nullable()->after('contacto_id');
            }
            if (!Schema::hasColumn('facturas', 'nota_venta_folio')) {
                $table->string('nota_venta_folio', 50)->nullable()->after('nota_venta_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (Schema::hasColumn('facturas', 'nota_venta_folio')) {
                $table->dropColumn('nota_venta_folio');
            }
            if (Schema::hasColumn('facturas', 'nota_venta_id')) {
                $table->dropColumn('nota_venta_id');
            }
        });
    }
};