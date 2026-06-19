<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos_activos', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('activo_id')->constrained('activos')->onDelete('cascade')->comment('Equipo que recibe mantenimiento');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->nullOnDelete()->comment('Proveedor del servicio');
            $table->foreignId('responsable_id')->nullable()->constrained('plantillas', 'plantilla_id')->nullOnDelete()->comment('Responsable del mantenimiento');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que registró');
            
            // Datos del mantenimiento
            $table->enum('tipo_mantenimiento', ['preventivo', 'correctivo', 'predictivo'])->default('preventivo')->comment('Tipo de mantenimiento');
            $table->string('folio', 50)->unique()->comment('Folio del mantenimiento');
            $table->text('descripcion')->comment('Descripción del trabajo realizado');
            $table->date('fecha_inicio')->comment('Fecha de inicio del mantenimiento');
            $table->date('fecha_fin')->nullable()->comment('Fecha de finalización');
            
            // Costos y métricas
            $table->decimal('costo', 15, 2)->default(0)->comment('Costo total del mantenimiento');
            $table->decimal('horometro_actual', 12, 2)->nullable()->comment('Horas al momento del mantenimiento');
            $table->decimal('horometro_proximo', 12, 2)->nullable()->comment('Horas para próximo mantenimiento');
            $table->integer('dias_proximo')->nullable()->comment('Días para próximo mantenimiento');
            
            // Estado
            $table->enum('estatus', ['pendiente', 'en_proceso', 'completado', 'cancelado'])->default('pendiente')->comment('Estatus del mantenimiento');
            $table->text('observaciones')->nullable()->comment('Notas adicionales');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('activo_id', 'idx_mantenimientos_activo');
            $table->index('tipo_mantenimiento', 'idx_mantenimientos_tipo');
            $table->index('estatus', 'idx_mantenimientos_estatus');
            $table->index('fecha_inicio', 'idx_mantenimientos_fecha_inicio');
            $table->index(['activo_id', 'estatus'], 'idx_mantenimientos_activo_estatus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos_activos');
    }
};