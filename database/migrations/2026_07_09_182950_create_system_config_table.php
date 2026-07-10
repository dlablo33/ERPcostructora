<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_config', function (Blueprint $table) {
            $table->id();
            
            // Clave y valor
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            
            // Metadatos
            $table->string('group', 50)->default('general'); // general, email, security, etc.
            $table->string('type', 20)->default('string');   // string, boolean, integer, json, file
            $table->string('label', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            
            // Estado
            $table->boolean('is_editable')->default(true);
            $table->boolean('is_visible')->default(true);
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('key');
            $table->index('group');
            $table->index('is_editable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_config');
    }
};