<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_depositos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            
            // Datos del depósito
            $table->string('folio', 50)->unique();
            $table->date('fecha');
            $table->decimal('monto', 15, 2);
            $table->string('concepto', 500);
            
            // Relaciones
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('set null');
            $table->foreignId('tipo_ingreso_id')->constrained('tipos_ingreso');
            
            // Estatus
            $table->enum('estatus', ['pendiente', 'aplicado', 'rechazado', 'proceso'])->default('pendiente');
            
            // Referencia
            $table->string('referencia', 100)->nullable();
            $table->string('comprobante', 255)->nullable();
            
            // Auditoría
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('folio');
            $table->index('fecha');
            $table->index('estatus');
            $table->index('cuenta_bancaria_id');
            $table->index('proyecto_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('depositos');
    }
};