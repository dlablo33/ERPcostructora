<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            
            // Número de contrato único
            $table->string('no_contrato', 50)->unique()->comment('Número de contrato único');
            
            // Relaciones
            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('contactos', 'contacto_id')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->comment('Cliente del contrato');
            
            $table->foreignId('proveedor_id')
                ->nullable()
                ->constrained('proveedores')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->comment('Proveedor/Contratista');
            
            // Fechas
            $table->date('fecha_firma')->comment('Fecha de firma del contrato');
            $table->date('fecha_inicio')->comment('Fecha de inicio del contrato');
            $table->date('fecha_fin')->comment('Fecha de término del contrato');
            
            // Montos
            $table->decimal('monto_total', 15, 2)->default(0)->comment('Monto total del contrato');
            $table->decimal('anticipo_porcentaje', 5, 2)->default(0)->comment('Porcentaje de anticipo');
            $table->decimal('anticipo_monto', 15, 2)->default(0)->comment('Monto del anticipo');
            $table->decimal('saldo_restante', 15, 2)->default(0)->comment('Saldo por ejercer');
            
            // Estado y versiones
            $table->enum('estado', ['Vigente', 'En Revisión', 'Vencido'])
                ->default('Vigente')
                ->comment('Estado del contrato');
            
            $table->string('version', 10)->default('v1.0')->comment('Versión actual del documento');
            
            // Descripción y condiciones
            $table->text('descripcion')->nullable()->comment('Descripción del alcance');
            $table->string('forma_pago', 100)->nullable()->comment('Forma de pago');
            $table->string('plazo_pago', 100)->nullable()->comment('Plazo de pago');
            $table->text('penalizaciones')->nullable()->comment('Cláusulas de penalización');
            $table->text('garantias')->nullable()->comment('Garantías del contrato');
            
            // Responsables
            $table->string('responsable_contratante', 100)->nullable()->comment('Representante del contratante');
            $table->string('cargo_contratante', 100)->nullable()->comment('Cargo del representante contratante');
            $table->string('email_contratante', 100)->nullable()->comment('Email del contratante');
            $table->string('rfc_cliente', 20)->nullable()->comment('RFC del cliente');
            
            $table->string('responsable_contratista', 100)->nullable()->comment('Representante del contratista');
            $table->string('cargo_contratista', 100)->nullable()->comment('Cargo del representante contratista');
            $table->string('email_contratista', 100)->nullable()->comment('Email del contratista');
            
            // Documento
            $table->string('documento_path', 255)->nullable()->comment('Ruta del archivo del contrato');
            $table->string('documento_nombre', 255)->nullable()->comment('Nombre original del archivo');
            $table->bigInteger('documento_tamanio')->default(0)->comment('Tamaño del archivo en bytes');
            
            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('estado');
            $table->index(['fecha_inicio', 'fecha_fin']);
            $table->index('fecha_firma');
            $table->index(['proyecto_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};