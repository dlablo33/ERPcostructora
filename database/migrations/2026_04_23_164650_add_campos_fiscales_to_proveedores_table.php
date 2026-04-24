<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Datos fiscales
            $table->string('alias', 100)->nullable()->after('nombre');
            $table->string('razon_social', 200)->nullable()->after('alias');
            $table->string('regimen_fiscal', 100)->nullable()->after('rfc');
            
            // Dirección completa (en lugar de un solo campo direccion)
            $table->string('calle', 150)->nullable()->after('regimen_fiscal');
            $table->string('num_ext', 20)->nullable()->after('calle');
            $table->string('num_int', 20)->nullable()->after('num_ext');
            $table->string('colonia', 150)->nullable()->after('num_int');
            $table->string('ciudad', 100)->nullable()->after('colonia');
            $table->string('estado', 100)->nullable()->after('ciudad');
            $table->string('codigo_postal', 10)->nullable()->after('estado');
            
            // Datos de crédito
            $table->decimal('limite_credito', 12, 2)->default(0)->after('codigo_postal');
            $table->decimal('credito_actual', 12, 2)->default(0)->after('limite_credito');
            
            // Datos de pago
            $table->string('forma_pago', 100)->nullable()->after('credito_actual');
            $table->string('metodo_pago', 100)->nullable()->after('forma_pago');
            $table->string('uso_cfdi', 100)->nullable()->after('metodo_pago');
            
            // Datos bancarios
            $table->string('banco', 100)->nullable()->after('uso_cfdi');
            $table->string('cuenta_bancaria', 50)->nullable()->after('banco');
            
            // Cuentas contables
            $table->string('cuenta_contable', 50)->nullable()->after('cuenta_bancaria');
            $table->string('cuenta_secundaria', 50)->nullable()->after('cuenta_contable');
            $table->string('cuenta_resultado', 50)->nullable()->after('cuenta_secundaria');
        });
    }

    public function down()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->dropColumn([
                'alias', 'razon_social', 'regimen_fiscal',
                'calle', 'num_ext', 'num_int', 'colonia', 'ciudad', 'estado', 'codigo_postal',
                'limite_credito', 'credito_actual',
                'forma_pago', 'metodo_pago', 'uso_cfdi',
                'banco', 'cuenta_bancaria',
                'cuenta_contable', 'cuenta_secundaria', 'cuenta_resultado'
            ]);
        });
    }
};