<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_contratistas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contratistas', function (Blueprint $table) {
            $table->id();
            
            // Relación con proveedores existentes
            $table->foreignId('proveedor_id')
                ->nullable()
                ->constrained('proveedores')
                ->onDelete('set null');
            
            // Datos principales
            $table->string('codigo', 50)->unique();
            $table->string('nombre_comercial', 200);
            $table->string('especialidad', 100);
            $table->string('nivel_riesgo', 20)->default('bajo');
            $table->decimal('calificacion', 3, 2)->default(0);
            
            // Documentos y registros
            $table->string('registro_imss', 20)->nullable();
            $table->string('licencia_obra', 50)->nullable();
            $table->date('fecha_registro')->default(now());
            $table->boolean('activo')->default(true);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('especialidad');
            $table->index('activo');
            $table->index('nivel_riesgo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratistas');
    }
};