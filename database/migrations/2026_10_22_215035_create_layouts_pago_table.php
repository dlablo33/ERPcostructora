<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layouts_pago', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 30)->unique();
            $table->date('fecha');
            $table->string('cuenta_nombre', 150)->nullable();
            $table->string('estatus', 30)->default('activo');
            $table->string('referencia', 100)->nullable();
            $table->string('moneda', 10)->default('MXN');
            $table->decimal('tipo_cambio', 14, 4)->default(1);
            $table->decimal('monto_total', 14, 2)->default(0);
            $table->string('tipo_programacion', 50)->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('cuenta_bancaria_id')->nullable()->constrained('cuentas_bancarias');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layouts_pago');
    }
};