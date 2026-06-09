<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tipos_ingreso', function (Blueprint $table) {
            if (!Schema::hasColumn('tipos_ingreso', 'codigo_sat_default_id')) {
                $table->unsignedBigInteger('codigo_sat_default_id')->nullable();
                $table->foreign('codigo_sat_default_id')
                    ->references('id')
                    ->on('codigos_sat')
                    ->onDelete('set null');
            }
        });
        
        Schema::table('tipos_egreso', function (Blueprint $table) {
            if (!Schema::hasColumn('tipos_egreso', 'codigo_sat_default_id')) {
                $table->unsignedBigInteger('codigo_sat_default_id')->nullable();
                $table->foreign('codigo_sat_default_id')
                    ->references('id')
                    ->on('codigos_sat')
                    ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('tipos_ingreso', function (Blueprint $table) {
            if (Schema::hasColumn('tipos_ingreso', 'codigo_sat_default_id')) {
                $table->dropForeign(['codigo_sat_default_id']);
                $table->dropColumn('codigo_sat_default_id');
            }
        });
        
        Schema::table('tipos_egreso', function (Blueprint $table) {
            if (Schema::hasColumn('tipos_egreso', 'codigo_sat_default_id')) {
                $table->dropForeign(['codigo_sat_default_id']);
                $table->dropColumn('codigo_sat_default_id');
            }
        });
    }
};