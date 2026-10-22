<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('almacenes', function (Blueprint $table) {
            // FK responsable (usuario del sistema)
            $table->unsignedBigInteger('responsable_id')->nullable()->after('responsable');
            $table->foreign('responsable_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            // FK cuenta contable
            $table->unsignedBigInteger('cuenta_contable_id')->nullable()->after('cuenta_contable');
            $table->foreign('cuenta_contable_id')
                  ->references('id')->on('cuentas_contables')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            // Índices para acelerar búsquedas
            $table->index('responsable_id');
            $table->index('cuenta_contable_id');
        });
    }

    public function down(): void
    {
        Schema::table('almacenes', function (Blueprint $table) {
            $table->dropForeign(['responsable_id']);
            $table->dropForeign(['cuenta_contable_id']);
            $table->dropColumn(['responsable_id', 'cuenta_contable_id']);
        });
    }
};