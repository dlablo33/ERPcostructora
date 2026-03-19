<?php

namespace Database\Seeders;

use App\Models\SatcatNominaContrato;
use Illuminate\Database\Seeder;

class SatcatNominaContratosSeeder extends Seeder
{
    public function run(): void
    {
        $contratos = [
            ['clave' => '01', 'descripcion' => 'Contrato de trabajo por tiempo indeterminado', 'activo' => true],
            ['clave' => '02', 'descripcion' => 'Contrato de trabajo para obra determinada', 'activo' => true],
            ['clave' => '03', 'descripcion' => 'Contrato de trabajo por tiempo determinado', 'activo' => true],
            ['clave' => '04', 'descripcion' => 'Contrato de trabajo por temporada', 'activo' => true],
            ['clave' => '05', 'descripcion' => 'Contrato de trabajo sujeto a prueba', 'activo' => true],
            ['clave' => '06', 'descripcion' => 'Contrato de trabajo con periodo de capacitación inicial', 'activo' => true],
            ['clave' => '07', 'descripcion' => 'Modalidad de contratación por pago de hora laborada', 'activo' => true],
            ['clave' => '08', 'descripcion' => 'Modalidad de trabajo por comisión laboral', 'activo' => true],
            ['clave' => '09', 'descripcion' => 'Modalidades de contratación donde no existe relación de trabajo', 'activo' => true],
            ['clave' => '10', 'descripcion' => 'Jubilación, pensión, retiro', 'activo' => true],
        ];

        foreach ($contratos as $contrato) {
            SatcatNominaContrato::updateOrCreate(
                ['clave' => $contrato['clave']],
                $contrato
            );
        }
    }
}