<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_activity_log', function (Blueprint $table) {
            // Hacer nullable las columnas subjectable
            $table->string('subjectable_type', 255)->nullable()->change();
            $table->unsignedBigInteger('subjectable_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_activity_log', function (Blueprint $table) {
            $table->string('subjectable_type', 255)->nullable(false)->change();
            $table->unsignedBigInteger('subjectable_id')->nullable(false)->change();
        });
    }
};