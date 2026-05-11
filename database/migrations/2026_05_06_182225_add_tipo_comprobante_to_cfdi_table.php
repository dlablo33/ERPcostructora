<?php
// database/migrations/2026_05_06_182225_add_tipo_comprobante_to_cfdi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cfdi', function (Blueprint $table) {
            // Verificar si la columna no existe antes de crearla
            if (!Schema::hasColumn('cfdi', 'comprobanteTipoDeComprobante')) {
                $table->string('comprobanteTipoDeComprobante', 2)->default('I')->after('comprobanteTotal');
            }
        });
    }

    public function down()
    {
        Schema::table('cfdi', function (Blueprint $table) {
            if (Schema::hasColumn('cfdi', 'comprobanteTipoDeComprobante')) {
                $table->dropColumn('comprobanteTipoDeComprobante');
            }
        });
    }
};