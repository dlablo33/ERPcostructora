<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla de áreas
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
        
        // Tabla de unidades de medida
        Schema::create('unidades_medida', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30)->unique();
            $table->string('abreviatura', 10);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
        
        // Insertar datos iniciales
        DB::table('areas')->insert([
            ['nombre' => 'Operaciones', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Proyectos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Almacén', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Recursos Humanos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Compras', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Finanzas', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mantenimiento', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Calidad', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sistemas', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Legal', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        DB::table('unidades_medida')->insert([
            ['nombre' => 'Pieza', 'abreviatura' => 'pz', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Kilogramo', 'abreviatura' => 'kg', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Litro', 'abreviatura' => 'l', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Metro', 'abreviatura' => 'm', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Caja', 'abreviatura' => 'caja', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Paquete', 'abreviatura' => 'pqt', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Juego', 'abreviatura' => 'jgo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rollo', 'abreviatura' => 'rollo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('unidades_medida');
        Schema::dropIfExists('areas');
    }
};