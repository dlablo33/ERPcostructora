<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_traspasos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('traspasos', function (Blueprint $table) {
            $table->id();
            
            // Datos del traspaso
            $table->string('folio', 50)->unique();
            $table->date('fecha');
            $table->decimal('monto', 15, 2);
            $table->string('concepto', 500)->nullable();
            
            // Cuentas involucradas
            $table->foreignId('cuenta_origen_id')->constrained('cuentas_bancarias');
            $table->foreignId('cuenta_destino_id')->constrained('cuentas_bancarias');
            
            // Monedas y tipo de cambio
            $table->foreignId('moneda_origen_id')->constrained('monedas');
            $table->foreignId('moneda_destino_id')->constrained('monedas');
            $table->decimal('tipo_cambio', 10, 4)->default(1);
            $table->decimal('monto_destino', 15, 2);
            
            // Estatus
            $table->enum('estatus', ['pendiente', 'procesado', 'completado', 'cancelado'])->default('pendiente');
            
            // Referencias
            $table->string('referencia', 100)->nullable();
            $table->string('referencia_bancaria', 100)->nullable();
            $table->string('poliza_contable', 50)->nullable();
            
            // Relación con proyecto (opcional)
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('set null');
            
            // Auditoría
            $table->text('observaciones')->nullable();
            $table->string('comprobante', 255)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('folio');
            $table->index('fecha');
            $table->index('estatus');
            $table->index('cuenta_origen_id');
            $table->index('cuenta_destino_id');
            $table->index('proyecto_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('traspasos');
    }
};