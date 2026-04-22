<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisiciones', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->unique();
            $table->date('fecha_requerimiento');
            $table->enum('estatus', ['Pendiente', 'Activo', 'Cotizado', 'Cancelado'])->default('Pendiente');
            $table->string('solicitante', 100);
            // Cambiamos area (string) por area_id (foreign key a tu tabla areas)
            $table->foreignId('area_id')->nullable()->constrained('areas')->nullOnDelete();
            $table->integer('cotizadas')->default(0);
            $table->text('observaciones')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('folio');
            $table->index('estatus');
            $table->index('fecha_requerimiento');
            $table->index('area_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisiciones');
    }
};