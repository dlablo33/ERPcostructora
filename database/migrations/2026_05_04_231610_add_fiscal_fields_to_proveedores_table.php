<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Si no tiene estos campos, agregarlos
            if (!Schema::hasColumn('proveedores', 'regimen_fiscal')) {
                $table->string('regimen_fiscal', 5)->nullable()->after('rfc');
            }
            if (!Schema::hasColumn('proveedores', 'uso_cfdi')) {
                $table->string('uso_cfdi', 5)->nullable()->after('regimen_fiscal');
            }
            if (!Schema::hasColumn('proveedores', 'forma_pago')) {
                $table->string('forma_pago', 5)->nullable()->after('uso_cfdi');
            }
            if (!Schema::hasColumn('proveedores', 'metodo_pago')) {
                $table->string('metodo_pago', 5)->nullable()->after('forma_pago');
            }
            if (!Schema::hasColumn('proveedores', 'email_facturacion')) {
                $table->string('email_facturacion')->nullable()->after('email');
            }
            if (!Schema::hasColumn('proveedores', 'calle')) {
                $table->string('calle', 150)->nullable()->after('direccion');
                $table->string('num_ext', 20)->nullable();
                $table->string('num_int', 20)->nullable();
                $table->string('colonia', 100)->nullable();
                $table->string('ciudad', 100)->nullable();
                $table->string('estado', 100)->nullable();
                $table->string('codigo_postal', 10)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->dropColumn([
                'regimen_fiscal',
                'uso_cfdi',
                'forma_pago',
                'metodo_pago',
                'email_facturacion',
                'calle',
                'num_ext',
                'num_int',
                'colonia',
                'ciudad',
                'estado',
                'codigo_postal'
            ]);
        });
    }
};