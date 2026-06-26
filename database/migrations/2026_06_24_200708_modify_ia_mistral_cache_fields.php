<?php
// database/migrations/2024_01_01_000000_modify_ia_mistral_cache_fields.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyIaMistralCacheFields extends Migration
{
    public function up()
    {
        Schema::table('ia_mistral_cache', function (Blueprint $table) {
            // Cambiar de varchar(500) a text
            $table->text('user_question')->change();
            $table->text('ai_response')->change();
            $table->text('context_hash')->change();
        });
    }

    public function down()
    {
        Schema::table('ia_mistral_cache', function (Blueprint $table) {
            $table->string('user_question', 500)->change();
            $table->string('ai_response', 500)->change();
            $table->string('context_hash', 500)->change();
        });
    }
}