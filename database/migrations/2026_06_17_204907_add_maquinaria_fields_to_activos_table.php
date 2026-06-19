<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activos', function (Blueprint $table) {
            // Agregar campos para mejor control de maquinaria
            if (!Schema::hasColumn('activos', 'costo_operacion_hora')) {
                $table->decimal('costo_operacion_hora', 15, 2)->default(0)->after('costo_adquisicion')->comment('Costo de operación por hora');
            }
            
            if (!Schema::hasColumn('activos', 'consumo_promedio')) {
                $table->decimal('consumo_promedio', 10, 2)->nullable()->after('costo_operacion_hora')->comment('Consumo promedio de combustible');
            }
            
            if (!Schema::hasColumn('activos', 'fecha_ultimo_mantenimiento')) {
                $table->date('fecha_ultimo_mantenimiento')->nullable()->after('fecha_adquisicion')->comment('Fecha del último mantenimiento');
            }
            
            if (!Schema::hasColumn('activos', 'fecha_proximo_mantenimiento')) {
                $table->date('fecha_proximo_mantenimiento')->nullable()->after('fecha_ultimo_mantenimiento')->comment('Fecha del próximo mantenimiento');
            }
        });
    }

    public function down(): void
    {
        Schema::table('activos', function (Blueprint $table) {
            $table->dropColumn([
                'costo_operacion_hora',
                'consumo_promedio',
                'fecha_ultimo_mantenimiento',
                'fecha_proximo_mantenimiento'
            ]);
        });
    }
};