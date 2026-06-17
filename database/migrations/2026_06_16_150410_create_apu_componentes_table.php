<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apu_componentes', function (Blueprint $table) {
            $table->id();
            
            // Relación con el APU
            $table->foreignId('apu_id')->constrained('analisis_precios_unitarios')->onDelete('cascade')->comment('APU al que pertenece');
            
            // Tipo de componente
            $table->enum('tipo_componente', ['material', 'mano_obra', 'maquinaria', 'subcontrato'])
                ->comment('Tipo de componente');
            
            // Referencia al catálogo correspondiente (nullable porque pueden ser datos libres)
            $table->foreignId('material_id')->nullable()->constrained('articulos')->nullOnDelete()->comment('FK a materiales');
            $table->foreignId('puesto_id')->nullable()->constrained('puestos')->nullOnDelete()->comment('FK a puestos (mano de obra)');
            $table->foreignId('maquinaria_id')->nullable()->constrained('activos_maquinaria')->nullOnDelete()->comment('FK a maquinaria');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->nullOnDelete()->comment('FK a proveedores (subcontratos)');
            
            // Datos del componente
            $table->string('descripcion', 500)->comment('Descripción del componente');
            $table->decimal('cantidad', 12, 4)->default(1)->comment('Cantidad por unidad de APU');
            $table->string('unidad', 20)->comment('Unidad de medida del componente');
            $table->decimal('costo_unitario', 15, 2)->default(0)->comment('Costo por unidad');
            $table->decimal('costo_total', 15, 2)->default(0)->comment('Cantidad × costo_unitario');
            
            // Control
            $table->integer('orden')->default(0)->comment('Orden de visualización');
            $table->text('observaciones')->nullable()->comment('Notas adicionales');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('apu_id');
            $table->index('tipo_componente');
            $table->index(['apu_id', 'tipo_componente'], 'idx_apu_tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apu_componentes');
    }
};