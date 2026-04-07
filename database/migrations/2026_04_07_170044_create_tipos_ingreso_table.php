<?php
// database/migrations/2024_01_01_000005_create_tipos_ingreso_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_ingreso', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Insertar tipos por defecto
        DB::table('tipos_ingreso')->insert([
            ['nombre' => 'Anticipo', 'descripcion' => 'Anticipo de cliente', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Estimación', 'descripcion' => 'Estimación de obra', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Finiquito', 'descripcion' => 'Finiquito de obra', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ajuste', 'descripcion' => 'Ajuste de contrato', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Otro', 'descripcion' => 'Otros ingresos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipos_ingreso');
    }
};