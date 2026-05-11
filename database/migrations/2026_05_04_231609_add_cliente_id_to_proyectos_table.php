<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // Agregar columna contacto_id (cliente)
            if (!Schema::hasColumn('proyectos', 'contacto_id')) {
                $table->unsignedBigInteger('contacto_id')->nullable()->after('id');
                $table->foreign('contacto_id')->references('contacto_id')->on('contactos')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            if (Schema::hasColumn('proyectos', 'contacto_id')) {
                $table->dropForeign(['contacto_id']);
                $table->dropColumn('contacto_id');
            }
        });
    }
};