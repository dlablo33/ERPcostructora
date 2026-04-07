<?php
// database/migrations/2024_01_01_000010_create_proyecto_saldos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proyecto_saldos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos');
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias');
            $table->decimal('saldo_asignado', 15, 2)->default(0);
            $table->decimal('saldo_disponible', 15, 2)->default(0);
            $table->decimal('total_ingresos', 15, 2)->default(0);
            $table->decimal('total_egresos', 15, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['proyecto_id', 'cuenta_bancaria_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyecto_saldos');
    }
};