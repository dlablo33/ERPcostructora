<?php

namespace Database\Seeders;

use App\Models\MovimientoInventario;
use App\Models\InventarioProyecto;
use App\Models\InventarioAlmacenProyecto;
use App\Models\Proyecto;
use App\Models\Articulo;
use App\Models\Almacen;
use Illuminate\Database\Seeder;

class MovimientoInventarioSeeder extends Seeder
{
    public function run()
    {
        // Obtener un proyecto, artículo y almacén existentes
        $proyecto = Proyecto::first();
        $articulo = Articulo::first();
        $almacen = Almacen::first();
        
        if (!$proyecto || !$articulo || !$almacen) {
            $this->command->error('❌ Faltan datos: Proyecto, Artículo o Almacén no existen');
            return;
        }
        
        // Crear o obtener inventario del proyecto
        $inventario = InventarioProyecto::firstOrCreate(
            [
                'proyecto_id' => $proyecto->id,
                'articulo_id' => $articulo->id
            ],
            [
                'cantidad_actual' => 100,
                'cantidad_reservada' => 0,
                'cantidad_minima' => 10,
                'cantidad_maxima' => 500,
                'punto_reorden' => 20,
                'unidad_medida' => $articulo->unidad_medida,
                'estatus' => 'Activo'
            ]
        );
        
        // Crear ubicación en almacén
        $ubicacion = InventarioAlmacenProyecto::firstOrCreate(
            [
                'inventario_proyecto_id' => $inventario->id,
                'almacen_id' => $almacen->id
            ],
            ['cantidad' => 100]
        );
        
        // Crear movimientos de prueba
        $movimientos = [
            [
                'inventario_proyecto_id' => $inventario->id,
                'almacen_destino_id' => $almacen->id,
                'tipo_movimiento' => 'Entrada',
                'cantidad' => 50,
                'cantidad_antes' => 50,
                'cantidad_despues' => 100,
                'referencia_tipo' => 'Compra',
                'referencia_folio' => 'FAC-001',
                'observaciones' => 'Compra inicial',
                'fecha_movimiento' => now(),
                'creado_por' => 1
            ],
            [
                'inventario_proyecto_id' => $inventario->id,
                'almacen_origen_id' => $almacen->id,
                'tipo_movimiento' => 'Salida',
                'cantidad' => 10,
                'cantidad_antes' => 100,
                'cantidad_despues' => 90,
                'referencia_tipo' => 'Consumo',
                'referencia_folio' => 'REQ-001',
                'solicitante' => 'Juan Pérez',
                'observaciones' => 'Material para obra',
                'fecha_movimiento' => now(),
                'creado_por' => 1
            ]
        ];
        
        foreach ($movimientos as $movimiento) {
            MovimientoInventario::create($movimiento);
        }
        
        $this->command->info('✅ Movimientos de prueba creados: ' . MovimientoInventario::count());
    }
}