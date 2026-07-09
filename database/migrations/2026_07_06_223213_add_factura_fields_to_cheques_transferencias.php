<?php
// database/migrations/YYYY_MM_DD_add_factura_fields_to_cheques_transferencias.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cheques_transferencias', function (Blueprint $table) {
            // Agregar campos si no existen
            if (!Schema::hasColumn('cheques_transferencias', 'proveedor_id')) {
                $table->foreignId('proveedor_id')->nullable()->after('proveedor')
                    ->constrained('proveedores')->nullOnDelete();
            }
            
            if (!Schema::hasColumn('cheques_transferencias', 'contacto_id')) {
                $table->foreignId('contacto_id')->nullable()->after('proveedor_id')
                    ->constrained('contactos', 'contacto_id')->nullOnDelete();
            }
            
            if (!Schema::hasColumn('cheques_transferencias', 'cliente_id')) {
                $table->foreignId('cliente_id')->nullable()->after('contacto_id')
                    ->constrained('contactos', 'contacto_id')->nullOnDelete();
            }
            
            if (!Schema::hasColumn('cheques_transferencias', 'codigo_sat_id')) {
                $table->foreignId('codigo_sat_id')->nullable()->after('created_by')
                    ->constrained('codigos_sat')->nullOnDelete();
            }
            
            if (!Schema::hasColumn('cheques_transferencias', 'tipo_aplicacion')) {
                $table->string('tipo_aplicacion')->default('pago')->after('codigo_sat_id')
                    ->comment('pago, deposito, transferencia');
            }
            
            if (!Schema::hasColumn('cheques_transferencias', 'facturas_aplicadas')) {
                $table->json('facturas_aplicadas')->nullable()->after('tipo_aplicacion')
                    ->comment('IDs de facturas y montos aplicados');
            }
            
            if (!Schema::hasColumn('cheques_transferencias', 'monto_aplicado')) {
                $table->decimal('monto_aplicado', 15, 2)->default(0)->after('facturas_aplicadas');
            }
            
            if (!Schema::hasColumn('cheques_transferencias', 'tipo_operacion')) {
                $table->string('tipo_operacion')->default('egreso')->after('monto_aplicado')
                    ->comment('ingreso, egreso');
            }
        });
    }

    public function down()
    {
        Schema::table('cheques_transferencias', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
            $table->dropForeign(['contacto_id']);
            $table->dropForeign(['cliente_id']);
            $table->dropForeign(['codigo_sat_id']);
            
            $table->dropColumn([
                'proveedor_id', 
                'contacto_id', 
                'cliente_id', 
                'codigo_sat_id',
                'tipo_aplicacion',
                'facturas_aplicadas',
                'monto_aplicado',
                'tipo_operacion'
            ]);
        });
    }
};