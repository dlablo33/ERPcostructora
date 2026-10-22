<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->id();

            // Identificación
            $table->string('numero_credito', 50)->unique();

            // ⬇️ FK al modelo existente Banco (tabla: bancos)
            $table->foreignId('banco_id')
                  ->constrained('bancos')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Fechas
            $table->date('fecha');
            $table->date('fecha_primer_pago')->nullable();
            $table->date('fecha_vencimiento')->nullable();

            // Montos
            $table->decimal('monto_total', 15, 2);
            $table->decimal('monto_pendiente', 15, 2)->default(0);
            $table->decimal('monto_capital', 15, 2);
            $table->decimal('monto_capital_restante', 15, 2);
            $table->decimal('monto_interes', 15, 2)->default(0);

            // Condiciones
            $table->string('parcialidad_actual', 20)->default('0/0');
            $table->decimal('tasa_interes', 8, 2)->nullable()->comment('Tasa anual en porcentaje');
            $table->integer('plazo_meses')->nullable();
            $table->integer('num_parcialidades')->nullable();
            $table->decimal('monto_parcialidad', 15, 2)->nullable();

            // Estado
            $table->enum('estado', ['activo', 'pagado', 'vencido', 'cancelado'])
                  ->default('activo');

            $table->text('notas')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('fecha');
            $table->index('estado');
            $table->index(['banco_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creditos');
    }
};