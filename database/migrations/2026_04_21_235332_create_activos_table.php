<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 200);
            $table->enum('tipo_activo', ['herramienta', 'maquinaria', 'vehiculo']);
            $table->string('categoria', 100)->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('serie', 100)->nullable();
            $table->year('anio')->nullable();
            $table->string('color', 50)->nullable();
            $table->string('ubicacion_fisica', 255)->nullable();
            $table->foreignId('proyecto_asignado_id')->nullable()->constrained('proyectos')->onDelete('set null');
            $table->date('fecha_asignacion')->nullable();
            $table->foreignId('responsable_asignado_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('estado_general', ['Excelente', 'Bueno', 'Regular', 'Malo', 'En reparacion'])->default('Bueno');
            $table->enum('estatus', ['Disponible', 'Asignado', 'En mantenimiento', 'Dado de baja'])->default('Disponible');
            $table->date('fecha_adquisicion')->nullable();
            $table->decimal('costo_adquisicion', 12, 2)->nullable();
            $table->decimal('valor_actual', 12, 2)->nullable();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->onDelete('set null');
            $table->string('factura', 100)->nullable();
            $table->string('cuenta_contable', 50)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('codigo');
            $table->index('tipo_activo');
            $table->index('estatus');
            $table->index('proyecto_asignado_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activos');
    }
};