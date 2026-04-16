<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_cheques_transferencias_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cheques_transferencias', function (Blueprint $table) {
            $table->id();
            
            // Datos principales
            $table->string('folio', 50)->unique();
            $table->enum('estatus', ['activo', 'cancelado', 'pendiente', 'completado'])->default('pendiente');
            $table->enum('forma_pago', ['cheque', 'transferencia'])->default('transferencia');
            
            // Datos del beneficiario/proveedor
            $table->string('proveedor', 200);
            $table->string('rfc', 20)->nullable();
            
            // Datos bancarios
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias');
            $table->string('referencia', 100)->nullable();
            $table->string('referencia_bancaria', 100)->nullable();
            
            // Fechas
            $table->date('fecha');
            $table->date('fecha_vencimiento')->nullable();
            
            // Montos
            $table->decimal('monto', 15, 2);
            $table->decimal('monto_restante', 15, 2)->default(0);
            
            // Moneda y tipo de cambio
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->decimal('tipo_cambio', 10, 4)->default(1);
            $table->decimal('monto_original', 15, 2)->nullable();
            
            // Descripción y documentos
            $table->text('descripcion')->nullable();
            $table->string('comprobante', 255)->nullable();
            
            // Póliza contable
            $table->string('poliza_contable', 50)->nullable();
            $table->foreignId('cuenta_contable_id')->nullable()->constrained('cuentas_contables');
            
            // Relación con proyecto (opcional)
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('set null');
            
            // Auditoría
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('folio');
            $table->index('fecha');
            $table->index('estatus');
            $table->index('forma_pago');
            $table->index('proveedor');
            $table->index('cuenta_bancaria_id');
            $table->index('proyecto_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cheques_transferencias');
    }
};