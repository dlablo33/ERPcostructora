<?php
// database/migrations/2026_03_25_174925_add_user_id_to_plantillas_table.php

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
        Schema::table('plantillas', function (Blueprint $table) {
            // Agregar user_id para relación con usuarios
            $table->unsignedBigInteger('user_id')->nullable()->after('plantilla_id');
            
            // Índice para búsquedas rápidas
            $table->index('user_id');
            
            // Llave foránea con users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantillas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};