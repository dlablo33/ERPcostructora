<?php
// database/seeders/ProyectoPartidasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use App\Models\ProyectoPartida;

class ProyectoPartidasSeeder extends Seeder
{
    public function run(): void
    {
        $proyecto = Proyecto::first();
        
        if (!$proyecto) {
            $this->command->error('No hay proyectos en la base de datos');
            return;
        }
        
        $partidas = [
            // CIMENTACION
            [
                'codigo' => 'CIM-001',
                'nombre' => 'Excavacion para cimentacion',
                'descripcion' => 'Excavacion a cielo abierto para zapatas',
                'seccion' => 'Cimentacion',
                'categoria' => 'maquinaria',
                'unidad' => 'm3',
                'cantidad' => 4500,
                'precio_unitario' => 120,
                'orden' => 1,
            ],
            [
                'codigo' => 'CIM-002',
                'nombre' => 'Acero de refuerzo',
                'descripcion' => 'Varilla de acero para zapatas',
                'seccion' => 'Cimentacion',
                'categoria' => 'materiales',
                'unidad' => 'kg',
                'cantidad' => 45000,
                'precio_unitario' => 32,
                'orden' => 2,
            ],
            [
                'codigo' => 'CIM-003',
                'nombre' => 'Concreto f=250 kg/cm2',
                'descripcion' => 'Concreto premezclado',
                'seccion' => 'Cimentacion',
                'categoria' => 'materiales',
                'unidad' => 'm3',
                'cantidad' => 850,
                'precio_unitario' => 2450,
                'orden' => 3,
            ],
            
            // ESTRUCTURA
            [
                'codigo' => 'EST-001',
                'nombre' => 'Columnas de concreto',
                'descripcion' => 'Columnas circulares',
                'seccion' => 'Estructura',
                'categoria' => 'materiales',
                'unidad' => 'm3',
                'cantidad' => 1250,
                'precio_unitario' => 2850,
                'orden' => 1,
            ],
            [
                'codigo' => 'EST-002',
                'nombre' => 'Losas de entrepiso',
                'descripcion' => 'Losas de concreto armado',
                'seccion' => 'Estructura',
                'categoria' => 'materiales',
                'unidad' => 'm2',
                'cantidad' => 8500,
                'precio_unitario' => 950,
                'orden' => 2,
            ],
            [
                'codigo' => 'EST-003',
                'nombre' => 'Mano de obra estructura',
                'descripcion' => 'Cuadrilla para estructura',
                'seccion' => 'Estructura',
                'categoria' => 'mano_obra',
                'unidad' => 'jor',
                'cantidad' => 3500,
                'precio_unitario' => 680,
                'orden' => 3,
            ],
            
            // ACABADOS
            [
                'codigo' => 'ACA-001',
                'nombre' => 'Piso ceramico',
                'descripcion' => 'Piso de ceramica 40x40',
                'seccion' => 'Acabados',
                'categoria' => 'materiales',
                'unidad' => 'm2',
                'cantidad' => 3200,
                'precio_unitario' => 480,
                'orden' => 1,
            ],
            [
                'codigo' => 'ACA-002',
                'nombre' => 'Pintura vinilica',
                'descripcion' => 'Pintura para interiores',
                'seccion' => 'Acabados',
                'categoria' => 'materiales',
                'unidad' => 'm2',
                'cantidad' => 12500,
                'precio_unitario' => 45,
                'orden' => 2,
            ],
            
            // INSTALACIONES
            [
                'codigo' => 'INS-001',
                'nombre' => 'Instalacion electrica',
                'descripcion' => 'Instalacion electrica completa',
                'seccion' => 'Instalaciones',
                'categoria' => 'subcontratos',
                'unidad' => 'global',
                'cantidad' => 1,
                'precio_unitario' => 3850000,
                'orden' => 1,
            ],
            [
                'codigo' => 'INS-002',
                'nombre' => 'Instalacion hidrosanitaria',
                'descripcion' => 'Instalacion hidrosanitaria completa',
                'seccion' => 'Instalaciones',
                'categoria' => 'subcontratos',
                'unidad' => 'global',
                'cantidad' => 1,
                'precio_unitario' => 2950000,
                'orden' => 2,
            ],
        ];
        
        foreach ($partidas as $partida) {
            ProyectoPartida::create(array_merge($partida, [
                'proyecto_id' => $proyecto->id,
                'activa' => true,
            ]));
        }
        
        $this->command->info('✅ ' . count($partidas) . ' partidas creadas para el proyecto ' . $proyecto->nombre);
    }
}