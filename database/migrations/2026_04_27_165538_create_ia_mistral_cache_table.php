<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ia_mistral_cache', function (Blueprint $table) {
            $table->id();
            $table->text('user_question');
            $table->string('ai_response', 500);
            $table->string('context_hash', 64);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index('context_hash');
            $table->index('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ia_mistral_cache');
    }
};