<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RequisicionesFinalSeeder extends Seeder
{
    public function run(): void
    {
        // Desactivar restricciones
        DB::statement('SET CONSTRAINTS ALL DEFERRED');
        
        // Limpiar tablas
        DB::table('requisicion_articulos')->delete();
        DB::table('requisiciones')->delete();
        
        // Obtener área existente o crear una
        $area = DB::table('areas')->first();
        if (!$area) {
            $areaId = DB::table('areas')->insertGetId([
                'folio' => 'AREA-001',
                'nombre' => 'Operaciones',
                'descripcion' => 'Área de operaciones',
                'cuenta_contable' => '5001',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $areaNombre = 'Operaciones';
        } else {
            $areaId = $area->id;
            $areaNombre = $area->nombre;
        }
        
        // Datos de requisiciones
        $requisiciones = [
            ['REQ-001', '2025-03-15', 'Activo', 'JUAN PÉREZ', $areaNombre, $areaId, 3, 'Requisición urgente para obra'],
            ['REQ-002', '2025-03-14', 'Pendiente', 'MARÍA GARCÍA', $areaNombre, $areaId, 0, 'Pendiente de autorización'],
            ['REQ-003', '2025-03-13', 'Activo', 'CARLOS LÓPEZ', $areaNombre, $areaId, 2, 'Material para almacén'],
            ['REQ-004', '2025-03-12', 'Pendiente', 'ANA MARTÍNEZ', $areaNombre, $areaId, 0, 'Papelería oficina'],
            ['REQ-005', '2025-03-11', 'Activo', 'ROBERTO SÁNCHEZ', $areaNombre, $areaId, 4, 'Compra de equipo'],
            ['REQ-006', '2025-03-10', 'Activo', 'LAURA FLORES', $areaNombre, $areaId, 2, 'Material de oficina'],
            ['REQ-007', '2025-03-09', 'Pendiente', 'JOSÉ TORRES', $areaNombre, $areaId, 0, 'Herramientas'],
            ['REQ-008', '2025-03-08', 'Activo', 'PATRICIA CASTILLO', $areaNombre, $areaId, 1, 'Equipo de seguridad'],
            ['REQ-009', '2025-03-07', 'Activo', 'FERNANDO GONZÁLEZ', $areaNombre, $areaId, 2, 'Mobiliario'],
            ['REQ-010', '2025-03-06', 'Pendiente', 'GABRIELA NAVARRO', $areaNombre, $areaId, 0, 'Papelería'],
        ];
        
        foreach ($requisiciones as $data) {
            // Insertar requisición con AMBAS columnas: area (texto) y area_id (foreign key)
            $reqId = DB::table('requisiciones')->insertGetId([
                'folio' => $data[0],
                'fecha_requerimiento' => $data[1],
                'estatus' => $data[2],
                'solicitante' => $data[3],
                'area' => $data[4],        // Columna de texto (NOT NULL)
                'area_id' => $data[5],     // Columna foreign key
                'cotizadas' => $data[6],
                'observaciones' => $data[7],
                'creado_por' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Insertar artículos para cada requisición
            $articulos = [
                [
                    'codigo' => 'HERR-001',
                    'cantidad' => 1,
                    'unidad_medida' => 'Pieza',
                    'descripcion' => 'Taladro Percutor 1/2"',
                    'observacion' => 'Marca Bosch profesional',
                    'pendiente' => true,
                ],
                [
                    'codigo' => 'MAT-001',
                    'cantidad' => 50,
                    'unidad_medida' => 'Kilogramo',
                    'descripcion' => 'Cemento Gris 50kg',
                    'observacion' => 'Para construcción',
                    'pendiente' => true,
                ],
                [
                    'codigo' => 'EQP-001',
                    'cantidad' => 2,
                    'unidad_medida' => 'Pieza',
                    'descripcion' => 'Andamio Metálico 3m',
                    'observacion' => 'Para trabajos en altura',
                    'pendiente' => false,
                ],
            ];
            
            // Insertar entre 1 y 3 artículos por requisición
            $numArticulos = rand(2, 3);
            for ($i = 0; $i < $numArticulos; $i++) {
                $art = $articulos[$i % count($articulos)];
                DB::table('requisicion_articulos')->insert([
                    'requisicion_id' => $reqId,
                    'codigo' => $art['codigo'] . '-' . $reqId,
                    'cantidad' => $art['cantidad'],
                    'unidad_medida' => $art['unidad_medida'],
                    'descripcion' => $art['descripcion'],
                    'observacion' => $art['observacion'],
                    'pendiente' => $art['pendiente'],
                    'cantidad_surtida' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        $totalReqs = DB::table('requisiciones')->count();
        $totalArts = DB::table('requisicion_articulos')->count();
        
        $this->command->info("✅ Se crearon {$totalReqs} requisiciones y {$totalArts} artículos");
    }
}