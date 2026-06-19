<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combustible_activos', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('activo_id')->constrained('activos')->onDelete('cascade')->comment('Equipo que recibe combustible');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->comment('Proyecto al que se carga');
            $table->foreignId('operador_id')->nullable()->constrained('plantillas', 'plantilla_id')->nullOnDelete()->comment('Operador que registra');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Usuario que registró');
            
            // Datos de la carga
            $table->string('folio', 50)->unique()->comment('Folio de la carga');
            $table->date('fecha')->comment('Fecha de la carga');
            $table->decimal('litros', 12, 2)->comment('Litros cargados');
            $table->decimal('costo', 15, 2)->comment('Costo total de la carga');
            $table->decimal('precio_litro', 10, 2)->comment('Precio por litro');
            $table->decimal('horometro', 12, 2)->nullable()->comment('Horas al momento de la carga');
            
            // Facturación
            $table->string('factura', 100)->nullable()->comment('Número de factura');
            $table->string('proveedor', 200)->nullable()->comment('Nombre del proveedor');
            
            // Estado
            $table->text('observaciones')->nullable()->comment('Notas adicionales');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('activo_id', 'idx_combustible_activo');
            $table->index('fecha', 'idx_combustible_fecha');
            $table->index(['activo_id', 'fecha'], 'idx_combustible_activo_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combustible_activos');
    }
};