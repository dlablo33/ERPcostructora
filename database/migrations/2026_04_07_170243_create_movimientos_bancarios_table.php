<?php
// database/migrations/2024_01_01_000009_create_movimientos_bancarios_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos_bancarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias');
            $table->foreignId('proyecto_id')->constrained('proyectos');
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->foreignId('tipo_ingreso_id')->nullable()->constrained('tipos_ingreso');
            $table->foreignId('tipo_egreso_id')->nullable()->constrained('tipos_egreso');
            $table->foreignId('categoria_gasto_id')->nullable()->constrained('categorias_gastos');
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago');
            $table->decimal('monto', 15, 2);
            $table->date('fecha');
            $table->string('concepto', 500);
            $table->string('referencia', 100)->nullable();
            $table->string('comprobante')->nullable();
            $table->enum('status', ['pendiente', 'aplicado', 'cancelado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['proyecto_id', 'fecha']);
            $table->index(['cuenta_bancaria_id', 'fecha']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_bancarios');
    }
};