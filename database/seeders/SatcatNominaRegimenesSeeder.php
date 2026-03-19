<?php

namespace Database\Seeders;

use App\Models\SatcatNominaRegimen;
use Illuminate\Database\Seeder;

class SatcatNominaRegimenesSeeder extends Seeder
{
    public function run(): void
    {
        $regimenes = [
            ['clave' => '02', 'descripcion' => 'Sueldos', 'activo' => true],
            ['clave' => '03', 'descripcion' => 'Jubilados', 'activo' => true],
            ['clave' => '04', 'descripcion' => 'Pensionados', 'activo' => true],
            ['clave' => '05', 'descripcion' => 'Asimilados a salarios', 'activo' => true],
            ['clave' => '06', 'descripcion' => 'Alimentación', 'activo' => true],
            ['clave' => '07', 'descripcion' => 'Habitación', 'activo' => true],
            ['clave' => '08', 'descripcion' => 'Premios por asistencia', 'activo' => true],
            ['clave' => '09', 'descripcion' => 'Premios por puntualidad', 'activo' => true],
            ['clave' => '10', 'descripcion' => 'Horas extra', 'activo' => true],
            ['clave' => '11', 'descripcion' => 'Prima dominical', 'activo' => true],
        ];

        foreach ($regimenes as $regimen) {
            SatcatNominaRegimen::updateOrCreate(
                ['clave' => $regimen['clave']],
                $regimen
            );
        }
    }
}