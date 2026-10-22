<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('factura_uuid', 100)->nullable()->after('factura');
            $table->decimal('factura_monto', 14, 2)->nullable()->after('factura_uuid');
            $table->date('factura_fecha')->nullable()->after('factura_monto');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn(['factura_uuid', 'factura_monto', 'factura_fecha']);
        });
    }
};