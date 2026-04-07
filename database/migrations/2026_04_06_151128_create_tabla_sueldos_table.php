<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabla_sueldos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 50)->unique();
            $table->date('fecha_ejecuto');
            $table->date('fecha_inicial');
            $table->date('fecha_final');
            $table->integer('cantidad_registros')->default(0);
            $table->decimal('monto', 12, 2)->default(0);
            $table->enum('estatus', ['Activo', 'Pendiente', 'Cancelado', 'Finalizado'])->default('Activo');
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabla_sueldos');
    }
};