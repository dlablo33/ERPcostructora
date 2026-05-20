<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conciliacion_bancaria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias')->onDelete('cascade');
            $table->string('folio', 20)->unique();
            $table->date('fecha_conciliacion');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->decimal('saldo_inicial_sistema', 14, 2)->default(0);
            $table->decimal('saldo_inicial_extracto', 14, 2)->default(0);
            $table->decimal('total_ingresos_sistema', 14, 2)->default(0);
            $table->decimal('total_egresos_sistema', 14, 2)->default(0);
            $table->decimal('total_ingresos_extracto', 14, 2)->default(0);
            $table->decimal('total_egresos_extracto', 14, 2)->default(0);
            $table->decimal('saldo_final_sistema', 14, 2)->default(0);
            $table->decimal('saldo_final_extracto', 14, 2)->default(0);
            $table->decimal('diferencia', 14, 2)->default(0);
            $table->string('archivo_excel')->nullable();
            $table->enum('estatus', ['Pendiente', 'En Proceso', 'Conciliado', 'Descuadre'])->default('Pendiente');
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conciliacion_bancaria');
    }
};