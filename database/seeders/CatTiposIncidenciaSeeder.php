<?php
// database/seeders/CatTiposIncidenciaSeeder.php

namespace Database\Seeders;

use App\Models\CatTipoIncidencia;
use Illuminate\Database\Seeder;

class CatTiposIncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Atraso con Cliente', 'descripcion' => 'Llegada tarde a cita con cliente', 'afecta_nomina' => false, 'requiere_autorizacion' => false],
            ['nombre' => 'Golpe a Unidad', 'descripcion' => 'Accidente o golpe a unidad de transporte', 'afecta_nomina' => true, 'requiere_autorizacion' => true],
            ['nombre' => 'Falta Injustificada', 'descripcion' => 'Ausencia sin justificación', 'afecta_nomina' => true, 'requiere_autorizacion' => false],
            ['nombre' => 'Permiso Médico', 'descripcion' => 'Ausencia por cita o incapacidad médica', 'afecta_nomina' => false, 'requiere_autorizacion' => true],
            ['nombre' => 'Infracción de Tránsito', 'descripcion' => 'Multa o infracción al manejar unidad', 'afecta_nomina' => true, 'requiere_autorizacion' => false],
            ['nombre' => 'Queja de Cliente', 'descripcion' => 'Queja reportada por cliente', 'afecta_nomina' => false, 'requiere_autorizacion' => true],
            ['nombre' => 'Incidente de Seguridad', 'descripcion' => 'Incidente relacionado con seguridad', 'afecta_nomina' => false, 'requiere_autorizacion' => true],
            ['nombre' => 'Horas Extra', 'descripcion' => 'Tiempo extra trabajado', 'afecta_nomina' => true, 'requiere_autorizacion' => true],
            ['nombre' => 'Falla Técnica', 'descripcion' => 'Falla técnica en equipo o sistema', 'afecta_nomina' => false, 'requiere_autorizacion' => false],
        ];

        foreach ($tipos as $tipo) {
            CatTipoIncidencia::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                array_merge($tipo, ['activo' => true, 'borrado_logico' => false])
            );
        }

        $this->command->info('Tipos de incidencias cargados: ' . count($tipos));
    }
}