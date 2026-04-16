<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estimaciones_partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained()->onDelete('cascade');
            $table->foreignId('partida_id')->constrained('proyecto_partidas')->onDelete('cascade');
            $table->date('fecha');
            $table->date('periodo_inicio')->nullable();
            $table->date('periodo_fin')->nullable();
            $table->decimal('avance_porcentaje', 5, 2); // 0-100
            $table->decimal('cantidad_ejecutada', 12, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->unique(['partida_id', 'fecha']);
        });
        
        Schema::table('movimientos_bancarios', function (Blueprint $table) {
            $table->foreignId('estimacion_id')->nullable()->constrained('estimaciones_partidas');
        });
    }

    public function down()
    {
        Schema::table('movimientos_bancarios', function (Blueprint $table) {
            $table->dropForeign(['estimacion_id']);
            $table->dropColumn('estimacion_id');
        });
        Schema::dropIfExists('estimaciones_partidas');
    }
};