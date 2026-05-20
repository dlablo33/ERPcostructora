<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gastos_fijos', function (Blueprint $table) {
            // Agregar columna de proyecto
            $table->foreignId('proyecto_id')
                  ->nullable()
                  ->after('proveedor_id')
                  ->constrained('proyectos', 'id')
                  ->onDelete('set null');
            
            // Agregar columna de cuenta contable
            $table->foreignId('cuenta_contable_id')
                  ->nullable()
                  ->after('proyecto_id')
                  ->constrained('cuentas_contables', 'id')
                  ->onDelete('set null');
            
            // Agregar periodicidad del gasto
            $table->string('periodicidad', 20)
                  ->default('Mensual')
                  ->after('importe')
                  ->comment('Mensual, Trimestral, Semestral, Anual');
            
            // Día de cobro (1-31)
            $table->integer('dia_cobro')
                  ->nullable()
                  ->after('periodicidad')
                  ->comment('Día del mes en que se cobra');
            
            // Día específico del mes para cobro (ej: 15)
            $table->integer('dia_mes_cobro')
                  ->nullable()
                  ->after('dia_cobro')
                  ->comment('Día específico del mes para cobro');
            
            // Mes de inicio de cobro
            $table->integer('mes_inicio_cobro')
                  ->nullable()
                  ->after('dia_mes_cobro')
                  ->comment('Mes de inicio de cobro (1-12)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gastos_fijos', function (Blueprint $table) {
            // Eliminar llaves foráneas primero
            $table->dropForeign(['proyecto_id']);
            $table->dropForeign(['cuenta_contable_id']);
            
            // Eliminar columnas
            $table->dropColumn([
                'proyecto_id',
                'cuenta_contable_id',
                'periodicidad',
                'dia_cobro',
                'dia_mes_cobro',
                'mes_inicio_cobro'
            ]);
        });
    }
};