<?php

namespace Database\Seeders;

use App\Models\SatcatNominaPeriodicidad;
use Illuminate\Database\Seeder;

class SatcatNominaPeriodicidadesSeeder extends Seeder
{
    public function run(): void
    {
        $periodicidades = [
            ['clave' => '01', 'descripcion' => 'Diario', 'dias' => 1, 'activo' => true],
            ['clave' => '02', 'descripcion' => 'Semanal', 'dias' => 7, 'activo' => true],
            ['clave' => '03', 'descripcion' => 'Catorcenal', 'dias' => 14, 'activo' => true],
            ['clave' => '04', 'descripcion' => 'Quincenal', 'dias' => 15, 'activo' => true],
            ['clave' => '05', 'descripcion' => 'Mensual', 'dias' => 30, 'activo' => true],
            ['clave' => '06', 'descripcion' => 'Bimestral', 'dias' => 60, 'activo' => true],
            ['clave' => '07', 'descripcion' => 'Unidad obra', 'dias' => 0, 'activo' => true],
            ['clave' => '08', 'descripcion' => 'Comisión', 'dias' => 0, 'activo' => true],
            ['clave' => '09', 'descripcion' => 'Precio alzado', 'dias' => 0, 'activo' => true],
            ['clave' => '10', 'descripcion' => 'Decenal', 'dias' => 10, 'activo' => true],
        ];

        foreach ($periodicidades as $periodicidad) {
            SatcatNominaPeriodicidad::updateOrCreate(
                ['clave' => $periodicidad['clave']],
                $periodicidad
            );
        }
    }
}