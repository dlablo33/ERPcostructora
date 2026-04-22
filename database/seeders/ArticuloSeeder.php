<?php

namespace Database\Seeders;

use App\Models\Articulo;
use App\Models\Familia;
use App\Models\Subfamilia;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder
{
    public function run()
    {
        // Obtener familias y subfamilias
        $herramientas = Familia::where('nombre', 'Herramientas')->first();
        $materiales = Familia::where('nombre', 'Materiales de Construcción')->first();
        $equipo = Familia::where('nombre', 'Maquinaria y Equipo')->first();
        $seguridad = Familia::where('nombre', 'Equipo de Seguridad')->first();
        
        $subElectricas = Subfamilia::where('nombre', 'Herramientas Eléctricas')->first();
        $subManuales = Subfamilia::where('nombre', 'Herramientas Manuales')->first();
        $subAcero = Subfamilia::where('nombre', 'Acero y Varilla')->first();
        $subConcreto = Subfamilia::where('nombre', 'Cemento y Concreto')->first();
        $subProteccion = Subfamilia::where('nombre', 'Protección Personal')->first();
        
        $articulos = [
            // Herramientas Eléctricas
            [
                'codigo' => 'ART-00001',
                'descripcion' => 'Taladro Percutor 1/2" Bosch',
                'numero_parte' => 'GBH-2-26',
                'familia_id' => $herramientas->id,
                'subfamilia_id' => $subElectricas->id,
                'ubicacion' => 'A-01',
                'minimo' => 5,
                'maximo' => 20,
                'punto_reorden' => 8,
                'unidad_medida' => 'Pieza',
                'cuenta_contable' => '1150-01-01-001',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ART-00002',
                'descripcion' => 'Pulidora Angular 7" Makita',
                'numero_parte' => 'GA7021',
                'familia_id' => $herramientas->id,
                'subfamilia_id' => $subElectricas->id,
                'ubicacion' => 'A-02',
                'minimo' => 3,
                'maximo' => 15,
                'punto_reorden' => 5,
                'unidad_medida' => 'Pieza',
                'cuenta_contable' => '1150-01-01-002',
                'estatus' => 'Activo'
            ],
            
            // Herramientas Manuales
            [
                'codigo' => 'ART-00003',
                'descripcion' => 'Martillo de Peña 32oz Truper',
                'numero_parte' => '16873',
                'familia_id' => $herramientas->id,
                'subfamilia_id' => $subManuales->id,
                'ubicacion' => 'B-01',
                'minimo' => 10,
                'maximo' => 50,
                'punto_reorden' => 15,
                'unidad_medida' => 'Pieza',
                'cuenta_contable' => '1150-01-02-001',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ART-00004',
                'descripcion' => 'Juego de Desarmadores 6pzas Stanley',
                'numero_parte' => '66-039',
                'familia_id' => $herramientas->id,
                'subfamilia_id' => $subManuales->id,
                'ubicacion' => 'B-02',
                'minimo' => 8,
                'maximo' => 30,
                'punto_reorden' => 10,
                'unidad_medida' => 'Juego',
                'cuenta_contable' => '1150-01-02-002',
                'estatus' => 'Activo'
            ],
            
            // Acero y Varilla
            [
                'codigo' => 'ART-00005',
                'descripcion' => 'Varilla Corrugada 3/8" x 12m',
                'numero_parte' => 'VAR-3/8-12',
                'familia_id' => $materiales->id,
                'subfamilia_id' => $subAcero->id,
                'ubicacion' => 'C-01',
                'minimo' => 50,
                'maximo' => 500,
                'punto_reorden' => 100,
                'unidad_medida' => 'Pieza',
                'cuenta_contable' => '1150-02-01-001',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ART-00006',
                'descripcion' => 'Alambrón Negro Calibre 12',
                'numero_parte' => 'AL-12',
                'familia_id' => $materiales->id,
                'subfamilia_id' => $subAcero->id,
                'ubicacion' => 'C-02',
                'minimo' => 30,
                'maximo' => 200,
                'punto_reorden' => 50,
                'unidad_medida' => 'Kilogramo',
                'cuenta_contable' => '1150-02-01-002',
                'estatus' => 'Activo'
            ],
            
            // Cemento y Concreto
            [
                'codigo' => 'ART-00007',
                'descripcion' => 'Cemento Gris CPC 30R 50kg',
                'numero_parte' => 'CEM-50',
                'familia_id' => $materiales->id,
                'subfamilia_id' => $subConcreto->id,
                'ubicacion' => 'D-01',
                'minimo' => 100,
                'maximo' => 1000,
                'punto_reorden' => 200,
                'unidad_medida' => 'Bulto',
                'cuenta_contable' => '1150-02-02-001',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ART-00008',
                'descripcion' => 'Concreto Premezclado Fc=250kg/cm2',
                'numero_parte' => 'CON-250',
                'familia_id' => $materiales->id,
                'subfamilia_id' => $subConcreto->id,
                'ubicacion' => 'D-02',
                'minimo' => 10,
                'maximo' => 100,
                'punto_reorden' => 20,
                'unidad_medida' => 'Metro Cúbico',
                'cuenta_contable' => '1150-02-02-002',
                'estatus' => 'Activo'
            ],
            
            // Equipo de Protección Personal
            [
                'codigo' => 'ART-00009',
                'descripcion' => 'Casco de Seguridad Tipo 1 Clase E',
                'numero_parte' => 'V-GARD',
                'familia_id' => $seguridad->id,
                'subfamilia_id' => $subProteccion->id,
                'ubicacion' => 'E-01',
                'minimo' => 20,
                'maximo' => 100,
                'punto_reorden' => 30,
                'unidad_medida' => 'Pieza',
                'cuenta_contable' => '1150-04-01-001',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ART-00010',
                'descripcion' => 'Guantes de Carnaza Talla M',
                'numero_parte' => 'GC-100',
                'familia_id' => $seguridad->id,
                'subfamilia_id' => $subProteccion->id,
                'ubicacion' => 'E-02',
                'minimo' => 50,
                'maximo' => 200,
                'punto_reorden' => 80,
                'unidad_medida' => 'Par',
                'cuenta_contable' => '1150-04-01-002',
                'estatus' => 'Activo'
            ],
        ];
        
        foreach ($articulos as $articulo) {
            Articulo::create($articulo);
        }
        
        $this->command->info('✅ Artículos creados: ' . Articulo::count());
    }
}