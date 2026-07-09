<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Datos del token
            $table->string('name', 100);
            $table->string('token', 255)->unique();
            $table->text('abilities')->nullable();  // JSON de permisos
            
            // Información del cliente
            $table->string('client_name', 100)->nullable();
            $table->string('client_ip', 45)->nullable();
            $table->text('client_user_agent')->nullable();
            
            // Estado
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('user_id');
            $table->index('token');
            $table->index('is_active');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_api_tokens');
    }
};