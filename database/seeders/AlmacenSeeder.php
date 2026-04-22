<?php

namespace Database\Seeders;

use App\Models\Almacen;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    public function run()
    {
        $almacenes = [
            [
                'codigo' => 'ALM-001',
                'nombre' => 'Almacén Central',
                'tipo' => 'General',
                'descripcion' => 'Almacén Central - Materiales de construcción, herramientas y equipo',
                'ubicacion' => 'Av. Principal #123, Col. Centro, Ciudad',
                'responsable' => 'Juan Pérez',
                'telefono' => '555-123-4567',
                'email' => 'almacen.central@empresa.com',
                'cuenta_contable' => '1150-01-001',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-002',
                'nombre' => 'Almacén Refrigerado',
                'tipo' => 'Refrigerado',
                'descripcion' => 'Almacén de productos perecederos y químicos con temperatura controlada',
                'ubicacion' => 'Av. Industrial #456, Col. Industrial',
                'responsable' => 'María García',
                'telefono' => '555-234-5678',
                'email' => 'refrigerado@empresa.com',
                'cuenta_contable' => '1150-02-002',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-003',
                'nombre' => 'Almacén de Materiales Peligrosos',
                'tipo' => 'Materiales Peligrosos',
                'descripcion' => 'Almacén para materiales inflamables y peligrosos con certificación',
                'ubicacion' => 'Carretera Norte KM 5, Zona Industrial',
                'responsable' => 'Carlos López',
                'telefono' => '555-345-6789',
                'email' => 'peligrosos@empresa.com',
                'cuenta_contable' => '1150-03-003',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-004',
                'nombre' => 'Almacén de Herramientas',
                'tipo' => 'Herramientas',
                'descripcion' => 'Almacén exclusivo para herramientas y equipo menor',
                'ubicacion' => 'Av. Herramientas #789, Col. Talleres',
                'responsable' => 'Ana Martínez',
                'telefono' => '555-456-7890',
                'email' => 'herramientas@empresa.com',
                'cuenta_contable' => '1150-04-004',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-005',
                'nombre' => 'Almacén de Maquinaria',
                'tipo' => 'Maquinaria',
                'descripcion' => 'Almacén para maquinaria pesada y equipo mayor',
                'ubicacion' => 'Parque Industrial Sur, Bodega 10',
                'responsable' => 'Roberto Sánchez',
                'telefono' => '555-567-8901',
                'email' => 'maquinaria@empresa.com',
                'cuenta_contable' => '1150-05-005',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-006',
                'nombre' => 'Almacén Temporal',
                'tipo' => 'Temporal',
                'descripcion' => 'Almacén temporal para proyectos específicos (actualmente sin uso)',
                'ubicacion' => 'Zona Industrial, Bodega 6',
                'responsable' => 'Laura Flores',
                'telefono' => '555-678-9012',
                'email' => 'temporal@empresa.com',
                'cuenta_contable' => '1150-06-006',
                'estatus' => 'Inactivo'
            ],
            [
                'codigo' => 'ALM-007',
                'nombre' => 'Almacén de Combustibles',
                'tipo' => 'Combustibles',
                'descripcion' => 'Almacén de combustibles y lubricantes',
                'ubicacion' => 'Carretera Sur KM 8, Parque Logístico',
                'responsable' => 'José Torres',
                'telefono' => '555-789-0123',
                'email' => 'combustibles@empresa.com',
                'cuenta_contable' => '1150-07-007',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-008',
                'nombre' => 'Almacén Obra TRC001',
                'tipo' => 'Obra',
                'descripcion' => 'Almacén en sitio de obra - Proyecto TRC001',
                'ubicacion' => 'Fracc. Los Pinos, Lote 23, Obra TRC001',
                'responsable' => 'Fernando González',
                'telefono' => '555-890-1234',
                'email' => 'obra.trc001@empresa.com',
                'cuenta_contable' => '1150-08-008',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-009',
                'nombre' => 'Almacén Obra PAC002',
                'tipo' => 'Obra',
                'descripcion' => 'Almacén en sitio de obra - Proyecto PAC002',
                'ubicacion' => 'Col. Las Palmas, Mz 12, Lote 5, Obra PAC002',
                'responsable' => 'Gabriela Navarro',
                'telefono' => '555-901-2345',
                'email' => 'obra.pac002@empresa.com',
                'cuenta_contable' => '1150-09-009',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'ALM-010',
                'nombre' => 'Almacén de Consumibles',
                'tipo' => 'Consumibles',
                'descripcion' => 'Almacén de artículos de oficina y consumibles',
                'ubicacion' => 'Edificio Administrativo, Piso 1',
                'responsable' => 'Patricia Castillo',
                'telefono' => '555-012-3456',
                'email' => 'consumibles@empresa.com',
                'cuenta_contable' => '1150-10-010',
                'estatus' => 'Activo'
            ],
        ];
        
        foreach ($almacenes as $almacen) {
            Almacen::create($almacen);
        }
        
        $this->command->info('✅ Almacenes creados: ' . Almacen::count());
        $this->command->info('   Activos: ' . Almacen::where('estatus', 'Activo')->count());
        $this->command->info('   Inactivos: ' . Almacen::where('estatus', 'Inactivo')->count());
    }
}