<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_module_configs_table.php

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
        Schema::create('module_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Nombre único del módulo (ej: bi_dashboard)');
            $table->string('display_name')->comment('Nombre visible del módulo (ej: Dashboard)');
            $table->string('icon')->nullable()->comment('Icono FontAwesome (ej: fa-tachometer-alt)');
            $table->string('section')->comment('Sección a la que pertenece (bi, administracion, contabilidad, etc)');
            $table->string('route')->nullable()->comment('Ruta del módulo');
            $table->boolean('is_enabled')->default(true)->comment('Estado del módulo (activo/inactivo)');
            $table->integer('order')->default(0)->comment('Orden de visualización');
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index('section');
            $table->index('is_enabled');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_configs');
    }
};