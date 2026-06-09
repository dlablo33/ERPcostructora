<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('polizas_contables', function (Blueprint $table) {
            $table->unsignedBigInteger('proyecto_id')->nullable()->after('carta_porte_id');
            $table->index('proyecto_id');
        });
    }

    public function down()
    {
        Schema::table('polizas_contables', function (Blueprint $table) {
            $table->dropColumn('proyecto_id');
        });
    }
};