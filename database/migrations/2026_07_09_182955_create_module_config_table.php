<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_config', function (Blueprint $table) {
            $table->id();
            
            // Datos del módulo
            $table->string('name', 50)->unique();
            $table->string('display_name', 100);
            $table->string('icon', 50)->default('fa-cube');
            $table->string('route', 255)->nullable();
            
            // Estado
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->integer('order')->default(0);
            
            // Permisos
            $table->json('required_roles')->nullable(); // Roles que pueden ver este módulo
            
            // Configuración
            $table->json('settings')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('name');
            $table->index('is_enabled');
            $table->index('is_visible');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_config');
    }
};