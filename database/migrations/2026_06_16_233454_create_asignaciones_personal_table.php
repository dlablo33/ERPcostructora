<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones_personal', function (Blueprint $table) {
            $table->id();
            
            // Relaciones principales
            $table->foreignId('empleado_id')->constrained('plantillas', 'plantilla_id')->onDelete('cascade')->comment('Empleado asignado');
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade')->comment('Proyecto al que se asigna');
            
            // Datos de la asignación
            $table->enum('tipo_personal', ['obrero', 'operador', 'supervisor', 'ingeniero', 'administrativo'])
                ->default('obrero')
                ->comment('Tipo de personal');
            
            $table->string('rol', 255)->comment('Rol específico en el proyecto');
            $table->date('fecha_asignacion')->comment('Fecha de inicio de asignación');
            $table->date('fecha_fin')->nullable()->comment('Fecha de fin de asignación (opcional)');
            
            // Datos económicos
            $table->decimal('salario_diario', 15, 2)->default(0)->comment('Salario diario en el proyecto');
            
            // Estado
            $table->enum('status', ['activo', 'inactivo', 'vacaciones', 'permiso'])
                ->default('activo')
                ->comment('Estado del personal en el proyecto');
            
            $table->text('observaciones')->nullable()->comment('Notas adicionales');
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que creó el registro');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('empleado_id', 'idx_asig_personal_empleado');
            $table->index('proyecto_id', 'idx_asig_personal_proyecto');
            $table->index('tipo_personal', 'idx_asig_personal_tipo');
            $table->index('status', 'idx_asig_personal_status');
            $table->index(['proyecto_id', 'tipo_personal'], 'idx_asig_personal_proy_tipo');
            $table->index(['empleado_id', 'proyecto_id'], 'idx_asig_personal_empleado_proyecto');
            
            // Unique para evitar duplicados (mismo empleado activo en el mismo proyecto)
            $table->unique(['empleado_id', 'proyecto_id', 'status'], 'idx_asig_personal_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones_personal');
    }
};