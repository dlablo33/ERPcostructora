<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Tipo y origen
            $table->string('type', 50)->default('system');  // system, project, task, alert, security, etc.
            $table->string('category', 50)->nullable();     // info, success, warning, danger
            $table->string('module', 50)->nullable();       // proyectos, rh, finanzas, etc.
            $table->unsignedBigInteger('reference_id')->nullable();  // ID del elemento referenciado
            
            // Contenido
            $table->string('title', 255);
            $table->text('message')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('color', 20)->nullable();
            
            // Acción
            $table->string('action_text', 50)->nullable();   // Ver, Aceptar, Rechazar, etc.
            $table->string('action_url', 255)->nullable();
            $table->json('action_data')->nullable();
            
            // Estado
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_dismissed')->default(false);
            $table->timestamp('dismissed_at')->nullable();
            
            // Notificaciones push
            $table->boolean('sent_email')->default(false);
            $table->timestamp('sent_email_at')->nullable();
            $table->boolean('sent_push')->default(false);
            $table->timestamp('sent_push_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('user_id');
            $table->index('type');
            $table->index('is_read');
            $table->index('created_at');
            $table->index(['user_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};