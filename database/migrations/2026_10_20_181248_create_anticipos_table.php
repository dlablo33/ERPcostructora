<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anticipos', function (Blueprint $table) {
            $table->id();

            // Folio único generado automáticamente: ANT-YYYY-0001
            $table->string('folio', 30)->unique();

            // Relaciones con tablas ya existentes
            $table->foreignId('proveedor_id')
                  ->constrained('proveedores')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreignId('cuenta_bancaria_id')
                  ->nullable()
                  ->constrained('cuentas_bancarias')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreignId('moneda_id')
                  ->constrained('monedas')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            // Datos del anticipo
            $table->string('forma_pago', 50);
            $table->date('fecha');
            $table->string('referencia', 100)->unique();
            $table->string('referencia_bancaria', 100)->nullable();
            $table->decimal('monto', 15, 2);
            $table->decimal('monto_restante', 15, 2);
            $table->decimal('tipo_cambio', 12, 4)->default(1);
            $table->string('descripcion', 500)->nullable();
            $table->enum('estatus', [
                'Pendiente',
                'Aprobado',
                'Rechazado',
                'Liquidado',
                'Cancelado',
            ])->default('Pendiente');

            // Índices para filtros y búsquedas
            $table->index('estatus');
            $table->index('fecha');
            $table->index(['proveedor_id', 'estatus']);
            $table->index('cuenta_bancaria_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anticipos');
    }
};