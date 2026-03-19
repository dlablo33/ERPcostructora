<?php

namespace Database\Seeders;

use App\Models\SatcatPais;
use Illuminate\Database\Seeder;

class SatcatPaisesSeeder extends Seeder
{
    public function run(): void
    {
        $paises = [
            ['clave' => 'MEX', 'descripcion' => 'México', 'nacionalidad' => 'Mexicana', 'activo' => true],
            ['clave' => 'USA', 'descripcion' => 'Estados Unidos', 'nacionalidad' => 'Estadounidense', 'activo' => true],
            ['clave' => 'CAN', 'descripcion' => 'Canadá', 'nacionalidad' => 'Canadiense', 'activo' => true],
            ['clave' => 'ESP', 'descripcion' => 'España', 'nacionalidad' => 'Española', 'activo' => true],
            ['clave' => 'ARG', 'descripcion' => 'Argentina', 'nacionalidad' => 'Argentina', 'activo' => true],
            ['clave' => 'COL', 'descripcion' => 'Colombia', 'nacionalidad' => 'Colombiana', 'activo' => true],
            ['clave' => 'VEN', 'descripcion' => 'Venezuela', 'nacionalidad' => 'Venezolana', 'activo' => true],
            ['clave' => 'PER', 'descripcion' => 'Perú', 'nacionalidad' => 'Peruana', 'activo' => true],
            ['clave' => 'CHL', 'descripcion' => 'Chile', 'nacionalidad' => 'Chilena', 'activo' => true],
            ['clave' => 'BRA', 'descripcion' => 'Brasil', 'nacionalidad' => 'Brasileña', 'activo' => true],
            ['clave' => 'FRA', 'descripcion' => 'Francia', 'nacionalidad' => 'Francesa', 'activo' => true],
            ['clave' => 'ITA', 'descripcion' => 'Italia', 'nacionalidad' => 'Italiana', 'activo' => true],
            ['clave' => 'DEU', 'descripcion' => 'Alemania', 'nacionalidad' => 'Alemana', 'activo' => true],
            ['clave' => 'GBR', 'descripcion' => 'Reino Unido', 'nacionalidad' => 'Británica', 'activo' => true],
        ];

        foreach ($paises as $pais) {
            SatcatPais::updateOrCreate(
                ['clave' => $pais['clave']],
                $pais
            );
        }
    }
}