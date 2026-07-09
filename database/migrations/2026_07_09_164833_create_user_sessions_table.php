<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Datos de sesión
            $table->string('session_id', 255)->unique();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            // Dispositivo
            $table->string('device_type', 50)->nullable();   // desktop, mobile, tablet
            $table->string('browser', 50)->nullable();
            $table->string('browser_version', 20)->nullable();
            $table->string('platform', 50)->nullable();      // Windows, macOS, iOS, Android, etc.
            
            // Ubicación
            $table->string('country', 50)->nullable();
            $table->string('city', 100)->nullable();
            
            // Estado
            $table->boolean('is_active')->default(true);
            $table->boolean('is_current')->default(false);
            $table->timestamp('last_activity')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('user_id');
            $table->index('session_id');
            $table->index('is_active');
            $table->index('last_activity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};