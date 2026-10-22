<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcialidades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('credito_id')
                  ->constrained('creditos')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->integer('numero');
            $table->date('fecha_vencimiento');
            $table->date('fecha_pago')->nullable();

            $table->decimal('monto', 15, 2);
            $table->decimal('capital', 15, 2);
            $table->decimal('interes', 15, 2);
            $table->decimal('saldo', 15, 2);

            $table->enum('estado', ['pendiente', 'pagada', 'vencida', 'parcial'])
                  ->default('pendiente');

            $table->text('notas')->nullable();

            $table->timestamps();

            $table->unique(['credito_id', 'numero']);
            $table->index('fecha_vencimiento');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcialidades');
    }
};