<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisicion_articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisicion_id')->constrained()->onDelete('cascade');
            $table->string('codigo', 50)->nullable();
            $table->decimal('cantidad', 12, 3)->default(1);
            $table->string('unidad_medida', 20)->default('Pieza');
            $table->string('descripcion', 500);
            $table->text('observacion')->nullable();
            $table->boolean('pendiente')->default(true);
            $table->foreignId('orden_compra_id')->nullable()->constrained('ordenes_compras')->nullOnDelete();
            $table->decimal('cantidad_surtida', 12, 3)->default(0);
            $table->timestamps();
            
            $table->index('requisicion_id');
            $table->index('codigo');
            $table->index('pendiente');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicion_articulos');
    }
};