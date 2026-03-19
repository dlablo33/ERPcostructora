<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar campos para RH
            $table->string('folio')->unique()->nullable()->after('id');
            $table->string('empleado')->nullable()->after('name');
            $table->string('rol')->nullable()->after('email');
            $table->string('estatus')->default('Activo')->after('rol');
            $table->softDeletes()->after('updated_at'); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['folio', 'empleado', 'rol', 'estatus', 'deleted_at']);
        });
    }
};