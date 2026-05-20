<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gastos_fijos', function (Blueprint $table) {
            $table->id('gasto_fijo_id');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores', 'id')->onDelete('set null');
            $table->string('descripcion', 255)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->decimal('importe', 12, 2)->default(0);
            $table->string('estatus', 20)->default('Activo');
            $table->string('cuenta_flujo_dinero', 50)->nullable();
            $table->string('satcat_uso_cfdi_clave', 10)->nullable();
            $table->string('satcat_metodos_pago_clave', 10)->nullable();
            $table->string('satcat_formas_pago_clave', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos_fijos');
    }
};