<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id();
            
            // Usuario
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Acción
            $table->string('action', 100);
            $table->string('module', 50)->nullable();
            $table->string('section', 50)->nullable();
            $table->string('subsection', 50)->nullable();
            
            // Cambios
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('metadata')->nullable();
            
            // Contexto
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('session_id', 255)->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('user_id');
            $table->index('action');
            $table->index('module');
            $table->index('section');
            $table->index('created_at');
            $table->index(['user_id', 'action']);
            $table->index(['module', 'section']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};