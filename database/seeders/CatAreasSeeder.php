<?php

namespace Database\Seeders;

use App\Models\CatArea;
use Illuminate\Database\Seeder;

class CatAreasSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['area' => 'Dirección General', 'descripcion' => 'Responsable de la estrategia y dirección de la empresa', 'activo' => true],
            ['area' => 'Administración', 'descripcion' => 'Gestión administrativa, recursos y servicios generales', 'activo' => true],
            ['area' => 'Contabilidad', 'descripcion' => 'Registro contable, declaraciones fiscales y finanzas', 'activo' => true],
            ['area' => 'Recursos Humanos', 'descripcion' => 'Gestión de personal, nómina, reclutamiento y desarrollo', 'activo' => true],
            ['area' => 'Operaciones', 'descripcion' => 'Supervisión de obras, logística y ejecución de proyectos', 'activo' => true],
            ['area' => 'Proyectos', 'descripcion' => 'Planificación, seguimiento y control de proyectos', 'activo' => true],
            ['area' => 'Compras', 'descripcion' => 'Adquisición de materiales, insumos y contratación de servicios', 'activo' => true],
            ['area' => 'Almacén', 'descripcion' => 'Control de inventarios, recepción y despacho de materiales', 'activo' => true],
            ['area' => 'Mantenimiento', 'descripcion' => 'Mantenimiento de maquinaria, equipos e instalaciones', 'activo' => true],
            ['area' => 'Seguridad e Higiene', 'descripcion' => 'Supervisión de medidas de seguridad, higiene y protección civil', 'activo' => true],
            ['area' => 'Sistemas', 'descripcion' => 'Soporte técnico, desarrollo de sistemas y administración de redes', 'activo' => true],
            ['area' => 'Calidad', 'descripcion' => 'Control de calidad en procesos y materiales', 'activo' => true],
            ['area' => 'Flotilla', 'descripcion' => 'Administración de vehículos y unidades de transporte', 'activo' => true],
            ['area' => 'Jurídico', 'descripcion' => 'Asesoría legal, contratos y representación legal', 'activo' => true],
            ['area' => 'Mercadotecnia', 'descripcion' => 'Estrategias de marketing, publicidad y relaciones públicas', 'activo' => true],
            ['area' => 'Ventas', 'descripcion' => 'Gestión de ventas y atención a clientes', 'activo' => true],
        ];

        foreach ($areas as $area) {
            CatArea::updateOrCreate(
                ['area' => $area['area']],
                $area
            );
        }
    }
}