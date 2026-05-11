<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios_bitacora', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bitacora_entry_id')->constrained('bitacora_entries')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('comentario');
            $table->timestamps();
            
            $table->index(['bitacora_entry_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios_bitacora');
    }
};