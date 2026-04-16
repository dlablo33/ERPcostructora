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
        // Verificar si la columna no existe antes de agregarla
        if (!Schema::hasColumn('proyecto_costos', 'subcontratos')) {
            Schema::table('proyecto_costos', function (Blueprint $table) {
                $table->decimal('subcontratos', 15, 2)->default(0)->nullable(false)->after('maquinaria');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Verificar si la columna existe antes de eliminarla
        if (Schema::hasColumn('proyecto_costos', 'subcontratos')) {
            Schema::table('proyecto_costos', function (Blueprint $table) {
                $table->dropColumn('subcontratos');
            });
        }
    }
};