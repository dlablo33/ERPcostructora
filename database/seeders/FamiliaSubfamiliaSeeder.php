<?php

namespace Database\Seeders;

use App\Models\Familia;
use App\Models\Subfamilia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamiliaSubfamiliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Para PostgreSQL - Desactivar verificaciones de llaves foráneas
        DB::statement('SET CONSTRAINTS ALL DEFERRED');
        
        // Limpiar tablas en orden correcto (primero las que tienen foreign keys)
        Subfamilia::query()->delete();
        Familia::query()->delete();
        
        // Reiniciar secuencias (para PostgreSQL)
        DB::statement('ALTER SEQUENCE familias_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE subfamilias_id_seq RESTART WITH 1');
        
        // ============================================
        // FAMILIAS PRINCIPALES
        // ============================================
        
        $familias = [
            [
                'codigo' => 'FAM-001',
                'nombre' => 'Herramientas',
                'descripcion' => 'Herramientas manuales, eléctricas y neumáticas para construcción y mantenimiento',
                'cuenta_contable' => '1150-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-002',
                'nombre' => 'Materiales de Construcción',
                'descripcion' => 'Materiales básicos para construcción como cemento, varilla, block, arena, grava',
                'cuenta_contable' => '1150-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-003',
                'nombre' => 'Maquinaria y Equipo',
                'descripcion' => 'Maquinaria pesada y equipo especializado para proyectos de construcción',
                'cuenta_contable' => '1150-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-004',
                'nombre' => 'Equipo de Seguridad',
                'descripcion' => 'Equipos de protección personal y artículos de seguridad industrial',
                'cuenta_contable' => '1150-04',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-005',
                'nombre' => 'Materiales Eléctricos',
                'descripcion' => 'Cables, interruptores, contactos, tableros y accesorios eléctricos',
                'cuenta_contable' => '1150-05',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-006',
                'nombre' => 'Plomería y Fontanería',
                'descripcion' => 'Tuberías, conexiones, llaves, bombas y accesorios para instalaciones hidrosanitarias',
                'cuenta_contable' => '1150-06',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-007',
                'nombre' => 'Pinturas y Acabados',
                'descripcion' => 'Pinturas, barnices, selladores y materiales para acabados',
                'cuenta_contable' => '1150-07',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-008',
                'nombre' => 'Oficina y Papelería',
                'descripcion' => 'Artículos de oficina, papelería y mobiliario administrativo',
                'cuenta_contable' => '1150-08',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-009',
                'nombre' => 'Combustibles y Lubricantes',
                'descripcion' => 'Gasolina, diésel, aceites, grasas y lubricantes para maquinaria',
                'cuenta_contable' => '1150-09',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-010',
                'nombre' => 'Refacciones y Mantenimiento',
                'descripcion' => 'Refacciones para maquinaria y equipo, y materiales para mantenimiento',
                'cuenta_contable' => '1150-10',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-011',
                'nombre' => 'Andamios y Estructuras',
                'descripcion' => 'Andamios, escaleras, plataformas y estructuras temporales',
                'cuenta_contable' => '1150-11',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'FAM-012',
                'nombre' => 'Topografía y Medición',
                'descripcion' => 'Equipos topográficos, niveles, teodolitos y herramientas de medición',
                'cuenta_contable' => '1150-12',
                'estatus' => 'Activo'
            ],
        ];
        
        foreach ($familias as $familiaData) {
            Familia::create($familiaData);
        }
        
        // ============================================
        // SUBFAMILIAS
        // ============================================
        
        // Obtener referencias de familias
        $herramientas = Familia::where('nombre', 'Herramientas')->first();
        $materiales = Familia::where('nombre', 'Materiales de Construcción')->first();
        $maquinaria = Familia::where('nombre', 'Maquinaria y Equipo')->first();
        $seguridad = Familia::where('nombre', 'Equipo de Seguridad')->first();
        $electricos = Familia::where('nombre', 'Materiales Eléctricos')->first();
        $plomeria = Familia::where('nombre', 'Plomería y Fontanería')->first();
        $pinturas = Familia::where('nombre', 'Pinturas y Acabados')->first();
        $oficina = Familia::where('nombre', 'Oficina y Papelería')->first();
        $combustibles = Familia::where('nombre', 'Combustibles y Lubricantes')->first();
        $refacciones = Familia::where('nombre', 'Refacciones y Mantenimiento')->first();
        $andamios = Familia::where('nombre', 'Andamios y Estructuras')->first();
        $topografia = Familia::where('nombre', 'Topografía y Medición')->first();
        
        $subfamilias = [
            // Herramientas (familia_id = 1)
            [
                'codigo' => 'SUB-001',
                'familia_id' => $herramientas->id,
                'nombre' => 'Herramientas Eléctricas',
                'descripcion' => 'Taladros, pulidoras, sierras eléctricas, rotomartillos',
                'cuenta_contable' => '1150-01-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-002',
                'familia_id' => $herramientas->id,
                'nombre' => 'Herramientas Manuales',
                'descripcion' => 'Martillos, desarmadores, llaves, pinzas, cintas métricas',
                'cuenta_contable' => '1150-01-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-003',
                'familia_id' => $herramientas->id,
                'nombre' => 'Herramientas Neumáticas',
                'descripcion' => 'Pistolas de aire, compresores, martillos neumáticos',
                'cuenta_contable' => '1150-01-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-004',
                'familia_id' => $herramientas->id,
                'nombre' => 'Herramientas de Corte',
                'descripcion' => 'Sierras, seguetas, cúteres, discos de corte',
                'cuenta_contable' => '1150-01-04',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-005',
                'familia_id' => $herramientas->id,
                'nombre' => 'Herramientas de Medición',
                'descripcion' => 'Flexómetros, niveles, escuadras, calibradores',
                'cuenta_contable' => '1150-01-05',
                'estatus' => 'Activo'
            ],
            
            // Materiales de Construcción (familia_id = 2)
            [
                'codigo' => 'SUB-006',
                'familia_id' => $materiales->id,
                'nombre' => 'Acero y Varilla',
                'descripcion' => 'Varilla corrugada, alambrón, malla electrosoldada',
                'cuenta_contable' => '1150-02-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-007',
                'familia_id' => $materiales->id,
                'nombre' => 'Cemento y Concreto',
                'descripcion' => 'Cemento gris, cemento blanco, concreto premezclado',
                'cuenta_contable' => '1150-02-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-008',
                'familia_id' => $materiales->id,
                'nombre' => 'Block y Tabique',
                'descripcion' => 'Block hueco, block sólido, tabique rojo, tabicón',
                'cuenta_contable' => '1150-02-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-009',
                'familia_id' => $materiales->id,
                'nombre' => 'Arena y Grava',
                'descripcion' => 'Arena de río, arena de mina, grava, sello',
                'cuenta_contable' => '1150-02-04',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-010',
                'familia_id' => $materiales->id,
                'nombre' => 'Madera y Triplay',
                'descripcion' => 'Madera para construcción, triplay, polines, tarimas',
                'cuenta_contable' => '1150-02-05',
                'estatus' => 'Activo'
            ],
            
            // Maquinaria y Equipo (familia_id = 3)
            [
                'codigo' => 'SUB-011',
                'familia_id' => $maquinaria->id,
                'nombre' => 'Maquinaria Pesada',
                'descripcion' => 'Excavadoras, retroexcavadoras, bulldozers, grúas',
                'cuenta_contable' => '1150-03-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-012',
                'familia_id' => $maquinaria->id,
                'nombre' => 'Equipo de Compactación',
                'descripcion' => 'Vibrocompactadores, planchas compactadoras, rodillos',
                'cuenta_contable' => '1150-03-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-013',
                'familia_id' => $maquinaria->id,
                'nombre' => 'Equipo de Concreto',
                'descripcion' => 'Revolvedoras, vibradores, bombas de concreto',
                'cuenta_contable' => '1150-03-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-014',
                'familia_id' => $maquinaria->id,
                'nombre' => 'Plantas de Luz',
                'descripcion' => 'Generadores eléctricos, plantas de emergencia',
                'cuenta_contable' => '1150-03-04',
                'estatus' => 'Activo'
            ],
            
            // Equipo de Seguridad (familia_id = 4)
            [
                'codigo' => 'SUB-015',
                'familia_id' => $seguridad->id,
                'nombre' => 'Protección Personal',
                'descripcion' => 'Cascos, guantes, lentes, tapones auditivos',
                'cuenta_contable' => '1150-04-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-016',
                'familia_id' => $seguridad->id,
                'nombre' => 'Protección para Alturas',
                'descripcion' => 'Arneses, líneas de vida, eslingas, anclajes',
                'cuenta_contable' => '1150-04-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-017',
                'familia_id' => $seguridad->id,
                'nombre' => 'Señalización',
                'descripcion' => 'Cintas de precaución, conos, letreros, banderas',
                'cuenta_contable' => '1150-04-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-018',
                'familia_id' => $seguridad->id,
                'nombre' => 'Equipo contra Incendios',
                'descripcion' => 'Extintores, mangueras, detectores de humo',
                'cuenta_contable' => '1150-04-04',
                'estatus' => 'Activo'
            ],
            
            // Materiales Eléctricos (familia_id = 5)
            [
                'codigo' => 'SUB-019',
                'familia_id' => $electricos->id,
                'nombre' => 'Cables y Alambres',
                'descripcion' => 'Cable THW, cable calibre, alambre de cobre',
                'cuenta_contable' => '1150-05-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-020',
                'familia_id' => $electricos->id,
                'nombre' => 'Accesorios Eléctricos',
                'descripcion' => 'Contactos, apagadores, interruptores, cajas de conexión',
                'cuenta_contable' => '1150-05-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-021',
                'familia_id' => $electricos->id,
                'nombre' => 'Tableros y Centros de Carga',
                'descripcion' => 'Tableros de distribución, pastillas, termomagnéticos',
                'cuenta_contable' => '1150-05-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-022',
                'familia_id' => $electricos->id,
                'nombre' => 'Lámparas e Iluminación',
                'descripcion' => 'Lámparas LED, focos, reflectores, luminarias',
                'cuenta_contable' => '1150-05-04',
                'estatus' => 'Activo'
            ],
            
            // Plomería y Fontanería (familia_id = 6)
            [
                'codigo' => 'SUB-023',
                'familia_id' => $plomeria->id,
                'nombre' => 'Tuberías y Conexiones',
                'descripcion' => 'Tubería PVC, CPVC, cobre, conexiones, codos, tes',
                'cuenta_contable' => '1150-06-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-024',
                'familia_id' => $plomeria->id,
                'nombre' => 'Llaves y Válvulas',
                'descripcion' => 'Llaves de paso, válvulas de compuerta, válvulas check',
                'cuenta_contable' => '1150-06-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-025',
                'familia_id' => $plomeria->id,
                'nombre' => 'Bombas y Motobombas',
                'descripcion' => 'Bombas sumergibles, bombas centrífugas, hidroneumáticos',
                'cuenta_contable' => '1150-06-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-026',
                'familia_id' => $plomeria->id,
                'nombre' => 'Accesorios de Baño',
                'descripcion' => 'WCs, lavabos, regaderas, mingitorios, llaves',
                'cuenta_contable' => '1150-06-04',
                'estatus' => 'Activo'
            ],
            
            // Pinturas y Acabados (familia_id = 7)
            [
                'codigo' => 'SUB-027',
                'familia_id' => $pinturas->id,
                'nombre' => 'Pinturas Vinílicas',
                'descripcion' => 'Pintura vinílica para interiores y exteriores',
                'cuenta_contable' => '1150-07-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-028',
                'familia_id' => $pinturas->id,
                'nombre' => 'Esmaltes y Barnices',
                'descripcion' => 'Esmalte para metal, barniz para madera',
                'cuenta_contable' => '1150-07-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-029',
                'familia_id' => $pinturas->id,
                'nombre' => 'Selladores e Impermeabilizantes',
                'descripcion' => 'Sellador para muros, impermeabilizante para azoteas',
                'cuenta_contable' => '1150-07-03',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-030',
                'familia_id' => $pinturas->id,
                'nombre' => 'Accesorios para Pintura',
                'descripcion' => 'Brochas, rodillos, charolas, cintas de enmascarar',
                'cuenta_contable' => '1150-07-04',
                'estatus' => 'Activo'
            ],
            
            // Oficina y Papelería (familia_id = 8)
            [
                'codigo' => 'SUB-031',
                'familia_id' => $oficina->id,
                'nombre' => 'Papelería Básica',
                'descripcion' => 'Hojas, carpetas, folders, libretas, plumas',
                'cuenta_contable' => '1150-08-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-032',
                'familia_id' => $oficina->id,
                'nombre' => 'Mobiliario de Oficina',
                'descripcion' => 'Escritorios, sillas, archiveros, estanterías',
                'cuenta_contable' => '1150-08-02',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-033',
                'familia_id' => $oficina->id,
                'nombre' => 'Equipo de Oficina',
                'descripcion' => 'Computadoras, impresoras, teléfonos, proyectores',
                'cuenta_contable' => '1150-08-03',
                'estatus' => 'Activo'
            ],
            
            // Combustibles y Lubricantes (familia_id = 9)
            [
                'codigo' => 'SUB-034',
                'familia_id' => $combustibles->id,
                'nombre' => 'Combustibles',
                'descripcion' => 'Gasolina magna, gasolina premium, diésel',
                'cuenta_contable' => '1150-09-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-035',
                'familia_id' => $combustibles->id,
                'nombre' => 'Lubricantes',
                'descripcion' => 'Aceite para motor, aceite hidráulico, grasas',
                'cuenta_contable' => '1150-09-02',
                'estatus' => 'Activo'
            ],
            
            // Refacciones y Mantenimiento (familia_id = 10)
            [
                'codigo' => 'SUB-036',
                'familia_id' => $refacciones->id,
                'nombre' => 'Refacciones para Maquinaria',
                'descripcion' => 'Filtros, balatas, empaques, mangueras',
                'cuenta_contable' => '1150-10-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-037',
                'familia_id' => $refacciones->id,
                'nombre' => 'Herramientas de Mantenimiento',
                'descripcion' => 'Juegos de dados, llaves especiales, gatos hidráulicos',
                'cuenta_contable' => '1150-10-02',
                'estatus' => 'Activo'
            ],
            
            // Andamios y Estructuras (familia_id = 11)
            [
                'codigo' => 'SUB-038',
                'familia_id' => $andamios->id,
                'nombre' => 'Andamios Metálicos',
                'descripcion' => 'Andamios modulares, torres de andamio, plataformas',
                'cuenta_contable' => '1150-11-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-039',
                'familia_id' => $andamios->id,
                'nombre' => 'Escaleras',
                'descripcion' => 'Escaleras de tijera, escaleras extensibles, escaleras de mano',
                'cuenta_contable' => '1150-11-02',
                'estatus' => 'Activo'
            ],
            
            // Topografía y Medición (familia_id = 12)
            [
                'codigo' => 'SUB-040',
                'familia_id' => $topografia->id,
                'nombre' => 'Equipo Topográfico',
                'descripcion' => 'Estaciones totales, teodolitos, niveles, GPS topográfico',
                'cuenta_contable' => '1150-12-01',
                'estatus' => 'Activo'
            ],
            [
                'codigo' => 'SUB-041',
                'familia_id' => $topografia->id,
                'nombre' => 'Accesorios Topográficos',
                'descripcion' => 'Trípodes, miras, prismas, cintas métricas',
                'cuenta_contable' => '1150-12-02',
                'estatus' => 'Activo'
            ],
        ];
        
        foreach ($subfamilias as $subfamiliaData) {
            Subfamilia::create($subfamiliaData);
        }
        
        // Reactivar constraints (opcional)
        DB::statement('SET CONSTRAINTS ALL IMMEDIATE');
        
        $this->command->info('✅ Familias creadas: ' . Familia::count());
        $this->command->info('✅ Subfamilias creadas: ' . Subfamilia::count());
    }
}