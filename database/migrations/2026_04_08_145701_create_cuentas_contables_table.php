<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_cuentas_contables_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cuentas_contables', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 200);
            $table->enum('tipo', ['activo', 'pasivo', 'capital', 'ingreso', 'gasto', 'costo'])->default('activo');
            $table->enum('naturaleza', ['deudora', 'acreedora'])->default('deudora');
            $table->string('codigo_padre', 20)->nullable();
            $table->integer('nivel')->default(1);
            $table->boolean('auxiliar')->default(false);
            $table->boolean('activa')->default(true);
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('codigo');
            $table->index('tipo');
            $table->index('codigo_padre');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuentas_contables');
    }
};