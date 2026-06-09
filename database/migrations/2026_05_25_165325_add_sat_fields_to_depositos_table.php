<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('depositos', function (Blueprint $table) {
            if (!Schema::hasColumn('depositos', 'codigo_sat_id')) {
                $table->unsignedBigInteger('codigo_sat_id')->nullable();
                $table->foreign('codigo_sat_id')
                    ->references('id')
                    ->on('codigos_sat')
                    ->onDelete('set null');
            }
            
            if (!Schema::hasColumn('depositos', 'cuenta_contable_id')) {
                $table->unsignedBigInteger('cuenta_contable_id')->nullable();
                $table->foreign('cuenta_contable_id')
                    ->references('id')
                    ->on('cuentas_contables')
                    ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('depositos', function (Blueprint $table) {
            if (Schema::hasColumn('depositos', 'codigo_sat_id')) {
                $table->dropForeign(['codigo_sat_id']);
                $table->dropColumn('codigo_sat_id');
            }
            
            if (Schema::hasColumn('depositos', 'cuenta_contable_id')) {
                $table->dropForeign(['cuenta_contable_id']);
                $table->dropColumn('cuenta_contable_id');
            }
        });
    }
};