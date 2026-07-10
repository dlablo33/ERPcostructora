<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_config', function (Blueprint $table) {
            $table->id();
            
            // Configuración SMTP
            $table->string('mailer', 20)->default('smtp');
            $table->string('host', 255)->default('smtp.gmail.com');
            $table->integer('port')->default(587);
            $table->string('encryption', 10)->nullable(); // tls, ssl
            $table->string('username', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('from_address', 255);
            $table->string('from_name', 255)->nullable();
            
            // Configuración de envío
            $table->string('reply_to_address', 255)->nullable();
            $table->string('reply_to_name', 255)->nullable();
            $table->integer('timeout')->default(30);
            $table->integer('max_emails_per_minute')->default(60);
            
            // Estado
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('last_test_at')->nullable();
            $table->text('last_test_error')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('is_active');
            $table->index('is_verified');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_config');
    }
};