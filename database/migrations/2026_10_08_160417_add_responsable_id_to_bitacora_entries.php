<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bitacora_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('bitacora_entries', 'responsable_id')) {
                $table->unsignedBigInteger('responsable_id')
                    ->nullable()
                    ->after('responsable');

                $table->foreign('responsable_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('bitacora_entries', function (Blueprint $table) {
            if (Schema::hasColumn('bitacora_entries', 'responsable_id')) {
                $table->dropForeign(['responsable_id']);
                $table->dropColumn('responsable_id');
            }
        });
    }
};