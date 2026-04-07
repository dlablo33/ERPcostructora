<?php
// database/migrations/2024_01_01_000001_create_monedas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('monedas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 3)->unique();
            $table->string('nombre', 100);
            $table->string('simbolo', 5);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        // Insertar monedas por defecto
        DB::table('monedas')->insert([
            ['codigo' => 'MXN', 'nombre' => 'Peso Mexicano', 'simbolo' => '$', 'activa' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'USD', 'nombre' => 'Dólar Americano', 'simbolo' => 'US$', 'activa' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('monedas');
    }
};