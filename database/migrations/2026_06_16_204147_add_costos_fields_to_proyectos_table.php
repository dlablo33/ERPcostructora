<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // Verificar si la columna existe antes de crearla
            if (!Schema::hasColumn('proyectos', 'costo_directo_acumulado')) {
                $table->decimal('costo_directo_acumulado', 15, 2)->default(0)->comment('Costo directo acumulado del proyecto');
            }
            
            if (!Schema::hasColumn('proyectos', 'costo_indirecto_acumulado')) {
                $table->decimal('costo_indirecto_acumulado', 15, 2)->default(0)->comment('Costo indirecto acumulado del proyecto');
            }
            
            if (!Schema::hasColumn('proyectos', 'costo_total_proyecto')) {
                $table->decimal('costo_total_proyecto', 15, 2)->default(0)->comment('Costo total del proyecto (directo + indirecto)');
            }
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn(['costo_directo_acumulado', 'costo_indirecto_acumulado', 'costo_total_proyecto']);
        });
    }
};