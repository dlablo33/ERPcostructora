<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_tipos_incidencias', function (Blueprint $table) {
            $table->id('cat_tipo_incidencia_id');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('clave_sat', 10)->nullable(); // Para CFDI si aplica
            $table->boolean('afecta_nomina')->default(false);
            $table->boolean('requiere_autorizacion')->default(false);
            $table->boolean('activo')->default(true);
            $table->boolean('borrado_logico')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_tipos_incidencias');
    }
};