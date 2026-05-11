<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacora_incidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bitacora_entry_id')->constrained('bitacora_entries')->onDelete('cascade');
            $table->string('codigo')->unique();
            $table->enum('tipo_incidencia', ['mecanica', 'personal', 'material', 'seguridad', 'clima', 'otros']);
            $table->enum('prioridad', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->text('accion_tomada')->nullable();
            $table->timestamp('resuelta_en')->nullable();
            $table->timestamps();
            
            $table->index('prioridad');
            $table->index('tipo_incidencia');
            $table->index('codigo');
            $table->index('bitacora_entry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora_incidencias');
    }
};