<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ia_knowledge_base', function (Blueprint $table) {
            $table->id();
            $table->string('keyword', 100);
            $table->string('module_name', 100)->nullable();
            $table->string('response_text', 500);
            $table->string('method_name', 100)->nullable();
            $table->string('controller_class', 255)->nullable();
            $table->integer('confidence_score')->default(0);
            $table->integer('times_used')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
            
            $table->index('keyword');
            $table->index('method_name');
            $table->index('confidence_score');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ia_knowledge_base');
    }
};