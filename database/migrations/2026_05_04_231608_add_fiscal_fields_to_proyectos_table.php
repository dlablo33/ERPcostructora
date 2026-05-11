<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // Agregar contacto_id para relacionar con tabla contactos
            if (!Schema::hasColumn('proyectos', 'contacto_id')) {
                $table->unsignedBigInteger('contacto_id')->nullable()->after('id');
                $table->foreign('contacto_id')->references('contacto_id')->on('contactos');
            }
            
            // Campos fiscales adicionales
            if (!Schema::hasColumn('proyectos', 'cliente_regimen_fiscal')) {
                $table->string('cliente_regimen_fiscal', 5)->nullable()->after('cliente_rfc');
            }
            if (!Schema::hasColumn('proyectos', 'cliente_uso_cfdi')) {
                $table->string('cliente_uso_cfdi', 5)->nullable()->after('cliente_regimen_fiscal');
            }
            if (!Schema::hasColumn('proyectos', 'cliente_forma_pago')) {
                $table->string('cliente_forma_pago', 5)->nullable()->after('cliente_uso_cfdi');
            }
            if (!Schema::hasColumn('proyectos', 'cliente_metodo_pago')) {
                $table->string('cliente_metodo_pago', 5)->nullable()->after('cliente_forma_pago');
            }
            if (!Schema::hasColumn('proyectos', 'cliente_direccion')) {
                $table->text('cliente_direccion')->nullable()->after('cliente_metodo_pago');
            }
        });
    }

    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            if (Schema::hasColumn('proyectos', 'contacto_id')) {
                $table->dropForeign(['contacto_id']);
                $table->dropColumn('contacto_id');
            }
            $table->dropColumn([
                'cliente_regimen_fiscal',
                'cliente_uso_cfdi',
                'cliente_forma_pago',
                'cliente_metodo_pago',
                'cliente_direccion'
            ]);
        });
    }
};