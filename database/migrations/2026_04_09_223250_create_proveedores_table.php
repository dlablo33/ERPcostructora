<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_proveedores_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('rfc', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('contacto', 200)->nullable();
            $table->string('direccion', 500)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Insertar proveedores de ejemplo
        DB::table('proveedores')->insert([
            ['nombre' => 'Transportes del Bajío', 'rfc' => 'TRA850101ABC', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Logística Monterrey', 'rfc' => 'LOG850202DEF', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Autotransportes Mexicanos', 'rfc' => 'AUT850303GHI', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ferrocarriles Nacionales', 'rfc' => 'FER850404JKL', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cervecería del Centro', 'rfc' => 'CER850505MNO', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Papelera del Pacífico', 'rfc' => 'PAP850606PQR', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Minería del Norte', 'rfc' => 'MIN850707STU', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Comercializadora del Sur', 'rfc' => 'COM850808VWX', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
};