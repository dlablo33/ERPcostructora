<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'folio' => 'ROL-001',
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso completo a todos los módulos del sistema, configuración y usuarios',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'ROL-002',
                'nombre' => 'Gerente de Proyectos',
                'descripcion' => 'Acceso a módulos de proyectos, reportes y asignación de recursos. Sin acceso a configuración.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'ROL-003',
                'nombre' => 'Supervisor de Obra',
                'descripcion' => 'Acceso a obras asignadas, reportes de avance, solicitud de materiales y asistencia.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'ROL-004',
                'nombre' => 'Residente de Obra',
                'descripcion' => 'Acceso completo a su obra, gestión de personal, reportes diarios y control de calidad.',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'ROL-005',
                'nombre' => 'Almacenista',
                'descripcion' => 'Acceso a inventarios, entradas y salidas de materiales, solicitudes de compra.',
                'estatus' => 'Activo'
            ]
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}