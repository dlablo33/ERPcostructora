<?php

namespace Database\Seeders;

use App\Models\JustificacionPermiso;
use Illuminate\Database\Seeder;

class JustificacionPermisoSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            [
                'folio' => 'JP-1001',
                'empleado_id' => 1,
                'empleado_nombre' => 'JUAN CARLOS PÉREZ LÓPEZ',
                'tipo' => 'Permiso Médico',
                'fecha_inicio' => '2025-03-15',
                'fecha_fin' => '2025-03-15',
                'dias' => 1,
                'estatus' => 'Aprobado',
                'tiene_justificante' => true,
                'motivo' => 'Cita médica especialista',
                'archivo_justificante' => 'justificantes/justificante_JP-1001.pdf'
            ],
            [
                'folio' => 'JP-1002',
                'empleado_id' => 2,
                'empleado_nombre' => 'MARÍA FERNANDA RAMOS GARCÍA',
                'tipo' => 'Permiso Personal',
                'fecha_inicio' => '2025-03-14',
                'fecha_fin' => '2025-03-14',
                'dias' => 1,
                'estatus' => 'Pendiente',
                'tiene_justificante' => false,
                'motivo' => 'Asuntos personales',
                'archivo_justificante' => null
            ],
            [
                'folio' => 'JP-1003',
                'empleado_id' => 3,
                'empleado_nombre' => 'CARLOS ALBERTO MENDOZA SÁNCHEZ',
                'tipo' => 'Incapacidad',
                'fecha_inicio' => '2025-03-10',
                'fecha_fin' => '2025-03-15',
                'dias' => 6,
                'estatus' => 'Aprobado',
                'tiene_justificante' => true,
                'motivo' => 'Incapacidad por enfermedad',
                'archivo_justificante' => 'justificantes/incapacidad_JP-1003.pdf'
            ],
            [
                'folio' => 'JP-1004',
                'empleado_id' => 4,
                'empleado_nombre' => 'ANA SOFÍA MARTÍNEZ FLORES',
                'tipo' => 'Permiso de Estudios',
                'fecha_inicio' => '2025-03-08',
                'fecha_fin' => '2025-03-08',
                'dias' => 1,
                'estatus' => 'Aprobado',
                'tiene_justificante' => true,
                'motivo' => 'Examen profesional',
                'archivo_justificante' => 'justificantes/estudios_JP-1004.pdf'
            ],
            [
                'folio' => 'JP-1005',
                'empleado_id' => 5,
                'empleado_nombre' => 'ROBERTO ANTONIO SÁNCHEZ TORRES',
                'tipo' => 'Permiso por Luto',
                'fecha_inicio' => '2025-03-05',
                'fecha_fin' => '2025-03-07',
                'dias' => 3,
                'estatus' => 'Aprobado',
                'tiene_justificante' => false,
                'motivo' => 'Fallecimiento de familiar directo',
                'archivo_justificante' => null
            ]
        ];
        
        foreach ($datos as $dato) {
            JustificacionPermiso::create($dato);
        }
    }
}