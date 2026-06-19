<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            // Agregar campo cuadrilla_id
            if (!Schema::hasColumn('asistencias', 'cuadrilla_id')) {
                $table->foreignId('cuadrilla_id')->nullable()->after('plantilla_id')->constrained('cuadrillas')->nullOnDelete()->comment('Cuadrilla a la que pertenece');
            }
        });
        
        // También agregar a detalle_listas_asistencia si existe
        if (Schema::hasTable('detalle_listas_asistencia')) {
            Schema::table('detalle_listas_asistencia', function (Blueprint $table) {
                if (!Schema::hasColumn('detalle_listas_asistencia', 'cuadrilla_id')) {
                    $table->foreignId('cuadrilla_id')->nullable()->after('empleado_id')->constrained('cuadrillas')->nullOnDelete()->comment('Cuadrilla del empleado');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropForeign(['cuadrilla_id']);
            $table->dropColumn('cuadrilla_id');
        });
        
        if (Schema::hasTable('detalle_listas_asistencia')) {
            Schema::table('detalle_listas_asistencia', function (Blueprint $table) {
                $table->dropForeign(['cuadrilla_id']);
                $table->dropColumn('cuadrilla_id');
            });
        }
    }
};