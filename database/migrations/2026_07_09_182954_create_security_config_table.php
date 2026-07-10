<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_config', function (Blueprint $table) {
            $table->id();
            
            // Políticas de contraseña
            $table->integer('password_min_length')->default(8);
            $table->integer('password_max_length')->default(255);
            $table->boolean('password_require_uppercase')->default(true);
            $table->boolean('password_require_lowercase')->default(true);
            $table->boolean('password_require_numbers')->default(true);
            $table->boolean('password_require_special')->default(false);
            $table->integer('password_expiration_days')->default(90);
            $table->integer('password_history_count')->default(5);
            
            // Autenticación
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_method', 20)->default('totp'); // totp, sms, email
            $table->integer('max_login_attempts')->default(5);
            $table->integer('lockout_time_minutes')->default(15);
            $table->boolean('session_timeout_enabled')->default(true);
            $table->integer('session_timeout_minutes')->default(30);
            
            // Sesiones
            $table->boolean('single_session_per_user')->default(false);
            $table->boolean('ip_restriction_enabled')->default(false);
            $table->json('allowed_ips')->nullable();
            $table->boolean('user_agent_restriction_enabled')->default(false);
            
            // Auditoría
            $table->boolean('audit_enabled')->default(true);
            $table->integer('audit_retention_days')->default(90);
            
            // Estado
            $table->boolean('is_active')->default(true);
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_config');
    }
};