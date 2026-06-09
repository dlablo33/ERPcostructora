<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('codigos_sat', function (Blueprint $table) {
            if (!Schema::hasColumn('codigos_sat', 'tipo')) {
                $table->enum('tipo', ['I', 'G', 'A', 'P'])->nullable()
                    ->comment('I=Ingreso, G=Gasto, A=Activo, P=Pasivo');
            }
        });
    }

    public function down()
    {
        Schema::table('codigos_sat', function (Blueprint $table) {
            if (Schema::hasColumn('codigos_sat', 'tipo')) {
                $table->dropColumn('tipo');
            }
        });
    }
};