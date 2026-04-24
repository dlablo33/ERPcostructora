<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->enum('estatus_cotizacion', ['Pendiente', 'En_Cotizacion', 'Cotizada'])->default('Pendiente')->after('estatus');
        });
    }

    public function down()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropColumn('estatus_cotizacion');
        });
    }
};