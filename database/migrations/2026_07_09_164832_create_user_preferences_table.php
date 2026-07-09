<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Apariencia
            $table->string('theme', 20)->default('light');
            $table->string('language', 10)->default('es');
            
            // Formato
            $table->string('timezone', 50)->default('America/Mexico_City');
            $table->string('date_format', 20)->default('d/m/Y');
            $table->string('time_format', 10)->default('H:i');
            $table->string('currency', 10)->default('MXN');
            $table->string('number_format', 10)->default('es');
            
            // Notificaciones
            $table->boolean('notifications_email')->default(true);
            $table->boolean('notifications_system')->default(true);
            $table->boolean('notifications_whatsapp')->default(false);
            
            // Dashboard
            $table->json('dashboard_widgets')->nullable();
            $table->json('favorite_menus')->nullable();
            
            // Firma
            $table->string('signature_path')->nullable();
            $table->json('default_document_config')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('user_id');
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};