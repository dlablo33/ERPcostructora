<?php
// database/migrations/2024_01_01_000002_create_tipos_cambio_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_cambio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moneda_origen_id')->constrained('monedas');
            $table->foreignId('moneda_destino_id')->constrained('monedas');
            $table->decimal('tasa', 10, 4);
            $table->date('fecha');
            $table->timestamps();
            
            $table->unique(['moneda_origen_id', 'moneda_destino_id', 'fecha']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_cambio');
    }
};