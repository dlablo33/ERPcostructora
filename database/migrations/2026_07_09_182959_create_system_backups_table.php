<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_backups', function (Blueprint $table) {
            $table->id();
            
            // Datos del backup
            $table->string('name', 100);
            $table->string('type', 50); // database, files, full
            $table->string('file_path', 255);
            $table->string('file_name', 255);
            $table->bigInteger('file_size')->nullable();
            
            // Metadatos
            $table->json('metadata')->nullable();
            $table->text('description')->nullable();
            
            // Estado
            $table->string('status', 20)->default('pending'); // pending, in_progress, completed, failed
            $table->timestamp('completed_at')->nullable();
            $table->text('error_message')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('type');
            $table->index('status');
            $table->index('created_at');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_backups');
    }
};