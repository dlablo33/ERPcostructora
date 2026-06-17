<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones_historial', function (Blueprint $table) {
            $table->id();
            
            // Relación con la asignación
            $table->foreignId('asignacion_id')->constrained('asignaciones_personal')->onDelete('cascade')->comment('Asignación relacionada');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que realizó el cambio');
            
            // Datos del cambio
            $table->enum('accion', ['asignacion', 'cambio_rol', 'cambio_proyecto', 'cambio_status', 'baja'])
                ->default('asignacion')
                ->comment('Tipo de acción realizada');
            
            $table->dateTime('fecha')->comment('Fecha y hora del cambio');
            $table->text('detalles')->nullable()->comment('Detalles del cambio');
            
            // Datos anteriores (para auditoría)
            $table->string('rol_anterior', 255)->nullable()->comment('Rol anterior');
            $table->string('rol_nuevo', 255)->nullable()->comment('Rol nuevo');
            $table->foreignId('proyecto_anterior_id')->nullable()->constrained('proyectos')->nullOnDelete()->comment('Proyecto anterior');
            $table->foreignId('proyecto_nuevo_id')->nullable()->constrained('proyectos')->nullOnDelete()->comment('Proyecto nuevo');
            $table->enum('status_anterior', ['activo', 'inactivo', 'vacaciones', 'permiso'])->nullable()->comment('Status anterior');
            $table->enum('status_nuevo', ['activo', 'inactivo', 'vacaciones', 'permiso'])->nullable()->comment('Status nuevo');
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('asignacion_id', 'idx_asig_historial_asignacion');
            $table->index('accion', 'idx_asig_historial_accion');
            $table->index('fecha', 'idx_asig_historial_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones_historial');
    }
};