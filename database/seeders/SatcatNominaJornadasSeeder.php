<?php

namespace Database\Seeders;

use App\Models\SatcatNominaJornada;
use Illuminate\Database\Seeder;

class SatcatNominaJornadasSeeder extends Seeder
{
    public function run(): void
    {
        $jornadas = [
            ['clave' => '01', 'descripcion' => 'Diurna', 'activo' => true],
            ['clave' => '02', 'descripcion' => 'Nocturna', 'activo' => true],
            ['clave' => '03', 'descripcion' => 'Mixta', 'activo' => true],
            ['clave' => '04', 'descripcion' => 'Por hora', 'activo' => true],
            ['clave' => '05', 'descripcion' => 'Reducida', 'activo' => true],
            ['clave' => '06', 'descripcion' => 'Continuada', 'activo' => true],
            ['clave' => '07', 'descripcion' => 'Partida', 'activo' => true],
            ['clave' => '08', 'descripcion' => 'Por turno', 'activo' => true],
        ];

        foreach ($jornadas as $jornada) {
            SatcatNominaJornada::updateOrCreate(
                ['clave' => $jornada['clave']],
                $jornada
            );
        }
    }
}