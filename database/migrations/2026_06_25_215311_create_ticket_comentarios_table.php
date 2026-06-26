<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('client_tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->text('comentario');
            $table->boolean('es_interno')->default(false);
            $table->timestamps();
            
            $table->index('ticket_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_comentarios');
    }
};