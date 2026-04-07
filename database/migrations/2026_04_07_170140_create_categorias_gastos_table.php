<?php
// database/migrations/2024_01_01_000007_create_categorias_gastos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categorias_gastos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->foreignId('tipo_egreso_id')->constrained('tipos_egreso');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Insertar categorías por defecto
        DB::table('categorias_gastos')->insert([
            // Materiales
            ['nombre' => 'Concreto', 'descripcion' => 'Concreto premezclado', 'tipo_egreso_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Acero', 'descripcion' => 'Varilla y acero de refuerzo', 'tipo_egreso_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Block/Ladrillo', 'descripcion' => 'Materiales de mampostería', 'tipo_egreso_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            // Mano de Obra
            ['nombre' => 'Albañiles', 'descripcion' => 'Cuadrilla de albañiles', 'tipo_egreso_id' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Electricistas', 'descripcion' => 'Cuadrilla de electricistas', 'tipo_egreso_id' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Plomeros', 'descripcion' => 'Cuadrilla de plomeros', 'tipo_egreso_id' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('categorias_gastos');
    }
};