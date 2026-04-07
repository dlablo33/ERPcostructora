<?php
// database/migrations/2024_01_01_000008_create_metodos_pago_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        DB::table('metodos_pago')->insert([
            ['nombre' => 'Transferencia', 'descripcion' => 'Transferencia bancaria', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cheque', 'descripcion' => 'Pago con cheque', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Efectivo', 'descripcion' => 'Pago en efectivo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta', 'descripcion' => 'Pago con tarjeta', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('metodos_pago');
    }
};