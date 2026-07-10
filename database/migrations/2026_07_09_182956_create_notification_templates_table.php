<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            
            // Datos de la plantilla
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->string('type', 50); // email, push, sms, whatsapp
            $table->string('category', 50)->nullable(); // system, project, task, security
            
            // Contenido
            $table->string('subject', 255)->nullable();
            $table->text('body')->nullable();
            $table->text('html_body')->nullable();
            
            // Variables disponibles
            $table->json('available_variables')->nullable();
            
            // Estado
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('code');
            $table->index('type');
            $table->index('category');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};