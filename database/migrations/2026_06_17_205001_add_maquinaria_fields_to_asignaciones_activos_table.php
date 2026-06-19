<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asignaciones_activos', function (Blueprint $table) {
            // Agregar campos para mejor control de asignaciones
            if (!Schema::hasColumn('asignaciones_activos', 'horas_estimadas')) {
                $table->decimal('horas_estimadas', 12, 2)->nullable()->after('horometro_devolucion')->comment('Horas estimadas de uso');
            }
            
            if (!Schema::hasColumn('asignaciones_activos', 'horas_reales')) {
                $table->decimal('horas_reales', 12, 2)->nullable()->after('horas_estimadas')->comment('Horas reales de uso');
            }
            
            if (!Schema::hasColumn('asignaciones_activos', 'fecha_estimada_devolucion')) {
                $table->date('fecha_estimada_devolucion')->nullable()->after('fecha_devolucion_real')->comment('Fecha estimada de devolución');
            }
            
            if (!Schema::hasColumn('asignaciones_activos', 'costo_estimado')) {
                $table->decimal('costo_estimado', 15, 2)->nullable()->after('costo_reparacion')->comment('Costo estimado de la asignación');
            }
            
            if (!Schema::hasColumn('asignaciones_activos', 'costo_real')) {
                $table->decimal('costo_real', 15, 2)->nullable()->after('costo_estimado')->comment('Costo real de la asignación');
            }
        });
    }

    public function down(): void
    {
        Schema::table('asignaciones_activos', function (Blueprint $table) {
            $table->dropColumn([
                'horas_estimadas',
                'horas_reales',
                'fecha_estimada_devolucion',
                'costo_estimado',
                'costo_real'
            ]);
        });
    }
};