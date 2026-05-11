<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencia_fotografica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bitacora_entry_id')->constrained('bitacora_entries')->onDelete('cascade');
            $table->string('ruta');
            $table->string('nombre_original');
            $table->string('mime_type');
            $table->integer('size');
            $table->text('descripcion')->nullable();
            $table->timestamps();
            
            $table->index('bitacora_entry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencia_fotografica');
    }
};