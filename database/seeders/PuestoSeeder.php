<?php

namespace Database\Seeders;

use App\Models\Puesto;
use Illuminate\Database\Seeder;

class PuestoSeeder extends Seeder
{
    public function run()
    {
        $puestos = [
            [
                'folio' => 'PUE-001',
                'nombre' => 'Arquitecto',
                'descripcion' => 'Diseño y supervisión de planos arquitectónicos, coordinación con clientes.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'PUE-002',
                'nombre' => 'Ingeniero Civil',
                'descripcion' => 'Cálculo estructural, supervisión de obra, control de calidad de materiales.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'PUE-003',
                'nombre' => 'Albañil',
                'descripcion' => 'Construcción de muros, columnas, losas y acabados en obra.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'PUE-004',
                'nombre' => 'Electricista',
                'descripcion' => 'Instalación y mantenimiento de sistemas eléctricos en obra.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'PUE-005',
                'nombre' => 'Plomero',
                'descripcion' => 'Instalación de tuberías, conexiones hidrosanitarias y accesorios.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'PUE-006',
                'nombre' => 'Carpintero',
                'descripcion' => 'Fabricación e instalación de estructuras de madera, cimbra y acabados.',
                'estatus' => 'Activo'
            ]
        ];

        foreach ($puestos as $puesto) {
            Puesto::create($puesto);
        }
    }
}