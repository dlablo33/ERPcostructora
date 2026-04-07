<?php

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
        // Tabla de conversaciones (para mantener hilos de chat)
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_one_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_two_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('last_read_at_user_one')->nullable();
            $table->timestamp('last_read_at_user_two')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index(['user_one_id', 'user_two_id']);
            // En lugar de unique, crear un índice compuesto y asegurar consistencia en el código
            $table->unique(['user_one_id', 'user_two_id']);
        });

        // Tabla de mensajes
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // quien envía
            $table->foreignId('recipient_id')->constrained('users')->onDelete('cascade'); // quien recibe
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_deleted_for_sender')->default(false);
            $table->boolean('is_deleted_for_recipient')->default(false);
            $table->timestamps();
            
            // Índices para optimizar consultas
            $table->index(['conversation_id', 'created_at']);
            $table->index(['user_id', 'recipient_id', 'created_at']);
            $table->index(['recipient_id', 'is_read', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
};