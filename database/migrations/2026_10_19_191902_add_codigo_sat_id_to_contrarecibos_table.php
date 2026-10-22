<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contrarecibos', function (Blueprint $table) {
            // Agregar columna codigo_sat_id con FK a codigos_sat.id
            $table->unsignedBigInteger('codigo_sat_id')
                ->nullable()
                ->after('referencia_bancaria');

            $table->foreign('codigo_sat_id')
                ->references('id')
                ->on('codigos_sat')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->index('codigo_sat_id');
        });
    }

    public function down(): void
    {
        Schema::table('contrarecibos', function (Blueprint $table) {
            $table->dropForeign(['codigo_sat_id']);
            $table->dropIndex(['codigo_sat_id']);
            $table->dropColumn('codigo_sat_id');
        });
    }
};