<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            
            // Datos Generales del Proyecto
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 255);
            $table->string('tipo_proyecto', 100);
            $table->string('categoria', 100)->nullable();
            $table->enum('prioridad', ['alta', 'media', 'baja'])->default('media');
            $table->string('ubicacion', 255);
            $table->text('direccion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['activo', 'en_curso', 'pendiente', 'en_espera'])->default('pendiente');
            $table->string('moneda', 3)->default('MXN');
            $table->decimal('tipo_cambio', 10, 4)->default(1.0000);
            
            // Datos del Cliente
            $table->string('cliente_nombre', 255);
            $table->string('cliente_rfc', 20);
            $table->string('cliente_email', 255)->nullable();
            $table->string('cliente_telefono', 50)->nullable();
            $table->string('cliente_contacto', 255)->nullable();
            $table->string('cliente_cargo', 255)->nullable();
            
            // Datos del Contrato
            $table->string('numero_contrato', 100);
            $table->date('fecha_firma')->nullable();
            $table->string('tipo_contrato', 100)->nullable();
            $table->string('forma_pago', 100)->nullable();
            $table->integer('plazo_pago')->nullable();
            
            // Responsable del Proyecto
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->string('cargo_responsable', 255)->nullable();
            $table->string('email_responsable', 255)->nullable();
            
            // Datos Financieros
            $table->decimal('presupuesto_total', 15, 2);
            $table->decimal('anticipo', 5, 2)->default(0);
            $table->decimal('margen', 5, 2)->default(0);
            $table->decimal('fondo_reserva', 15, 2)->default(0);
            
            // Estado del Registro
            $table->enum('status', ['borrador', 'activo', 'cancelado'])->default('borrador');
            
            // Auditoría
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices y Foreign Keys
            $table->index('codigo');
            $table->index('responsable_id');
            $table->index('cliente_rfc');
            $table->index('status');
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
            
            // Foreign key (descomenta si tienes la tabla users)
            // $table->foreign('responsable_id')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};