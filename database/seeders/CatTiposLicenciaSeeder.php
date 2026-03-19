<?php

namespace Database\Seeders;

use App\Models\CatTipoLicencia;
use Illuminate\Database\Seeder;

class CatTiposLicenciaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['tipo_licencia' => 'A', 'descripcion' => 'Automovilista - Chofer', 'activo' => true],
            ['tipo_licencia' => 'B', 'descripcion' => 'Chofer - Servicios particulares', 'activo' => true],
            ['tipo_licencia' => 'C', 'descripcion' => 'Servicio público de pasajeros', 'activo' => true],
            ['tipo_licencia' => 'D', 'descripcion' => 'Servicio público de carga', 'activo' => true],
            ['tipo_licencia' => 'E', 'descripcion' => 'Servicio federal de pasajeros', 'activo' => true],
            ['tipo_licencia' => 'F', 'descripcion' => 'Servicio federal de carga', 'activo' => true],
        ];

        foreach ($tipos as $tipo) {
            CatTipoLicencia::updateOrCreate(
                ['tipo_licencia' => $tipo['tipo_licencia']],
                $tipo
            );
        }
    }
}