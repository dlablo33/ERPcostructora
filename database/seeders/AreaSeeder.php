<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run()
    {
        $areas = [
            [
                'folio' => 'AR-001',
                'nombre' => 'Dirección General',
                'descripcion' => 'Responsable de la estrategia y dirección de la empresa',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-002',
                'nombre' => 'Administración',
                'descripcion' => 'Gestión administrativa, recursos y servicios generales',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-003',
                'nombre' => 'Contabilidad',
                'descripcion' => 'Registro contable, declaraciones fiscales y finanzas',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-004',
                'nombre' => 'Recursos Humanos',
                'descripcion' => 'Gestión de personal, nómina, reclutamiento y desarrollo',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-005',
                'nombre' => 'Operaciones',
                'descripcion' => 'Supervisión de obras, logística y ejecución de proyectos',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-006',
                'nombre' => 'Proyectos',
                'descripcion' => 'Planificación, seguimiento y control de proyectos',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-007',
                'nombre' => 'Compras',
                'descripcion' => 'Adquisición de materiales, insumos y contratación de servicios',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-008',
                'nombre' => 'Almacén',
                'descripcion' => 'Control de inventarios, recepción y despacho de materiales',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-009',
                'nombre' => 'Mantenimiento',
                'descripcion' => 'Mantenimiento de maquinaria, equipos e instalaciones',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-010',
                'nombre' => 'Seguridad e Higiene',
                'descripcion' => 'Supervisión de medidas de seguridad, higiene y protección civil',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-011',
                'nombre' => 'Sistemas',
                'descripcion' => 'Soporte técnico, desarrollo de sistemas y administración de redes',
                'cuenta_contable' => null
            ],
            [
                'folio' => 'AR-012',
                'nombre' => 'Calidad',
                'descripcion' => 'Control de calidad en procesos y materiales',
                'cuenta_contable' => null
            ]
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}