<?php
// database/migrations/2024_01_01_000006_create_tipos_egreso_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_egreso', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Insertar tipos por defecto
        DB::table('tipos_egreso')->insert([
            ['nombre' => 'Materiales', 'descripcion' => 'Compra de materiales', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mano de Obra', 'descripcion' => 'Pago de mano de obra', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Maquinaria', 'descripcion' => 'Renta o compra de maquinaria', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Subcontratos', 'descripcion' => 'Pago a subcontratistas', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gastos Administrativos', 'descripcion' => 'Gastos de administración', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gastos de Operación', 'descripcion' => 'Gastos operativos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Otro', 'descripcion' => 'Otros egresos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipos_egreso');
    }
};