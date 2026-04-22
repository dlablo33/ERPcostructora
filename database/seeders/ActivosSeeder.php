<?php

namespace Database\Seeders;

use App\Models\Activo;
use App\Models\ActivoHerramienta;
use App\Models\ActivoMaquinaria;
use App\Models\ActivoVehiculo;
use App\Models\RequisicionActivo;
use App\Models\AsignacionActivo;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivosSeeder extends Seeder
{
    public function run()
    {
        // Para PostgreSQL - Desactivar verificaciones de llaves foráneas
        DB::statement('SET CONSTRAINTS ALL DEFERRED');
        
        // Limpiar tablas en orden correcto
        AsignacionActivo::query()->delete();
        RequisicionActivo::query()->delete();
        ActivoHerramienta::query()->delete();
        ActivoMaquinaria::query()->delete();
        ActivoVehiculo::query()->delete();
        Activo::query()->delete();
        
        // Reiniciar secuencias (para PostgreSQL)
        DB::statement('ALTER SEQUENCE activos_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE activos_herramientas_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE activos_maquinaria_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE activos_vehiculos_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE requisiciones_activos_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE asignaciones_activos_id_seq RESTART WITH 1');

        // Obtener proyectos existentes
        $proyecto1 = Proyecto::where('codigo', 'PRO-2024-001')->orWhere('nombre', 'like', '%Torre%')->first();
        $proyecto2 = Proyecto::where('codigo', 'PRO-2024-002')->orWhere('nombre', 'like', '%Puente%')->first();
        $proyecto3 = Proyecto::where('codigo', 'PRO-2024-003')->orWhere('nombre', 'like', '%Parque%')->first();
        
        if (!$proyecto1) {
            $proyecto1 = Proyecto::first();
        }
        if (!$proyecto2) {
            $proyecto2 = $proyecto1;
        }
        if (!$proyecto3) {
            $proyecto3 = $proyecto1;
        }

        $usuarioId = User::first()?->id ?? 1;

        // ============================================
        // ACTIVOS (EQUIPOS, MAQUINARIA, VEHÍCULOS)
        // ============================================

        // 1. Excavadoras (Maquinaria)
        $excavadora1 = Activo::create([
            'codigo' => 'EX-001',
            'nombre' => 'Excavadora Caterpillar 320D',
            'tipo_activo' => 'maquinaria',
            'categoria' => 'Excavadora',
            'marca' => 'Caterpillar',
            'modelo' => '320D',
            'serie' => 'CAT320D-2022-001',
            'anio' => 2022,
            'color' => 'Amarillo',
            'ubicacion_fisica' => 'Almacén Central - Zona A',
            'proyecto_asignado_id' => $proyecto1->id,
            'fecha_asignacion' => '2025-03-01',
            'estado_general' => 'Bueno',
            'estatus' => 'Asignado',
            'fecha_adquisicion' => '2022-06-15',
            'costo_adquisicion' => 3500000,
            'valor_actual' => 2800000,
            'cuenta_contable' => '1150-03-01-001',
            'descripcion' => 'Excavadora de orugas para movimiento de tierra',
            'created_by' => $usuarioId
        ]);

        ActivoMaquinaria::create([
            'activo_id' => $excavadora1->id,
            'horometro_actual' => 1245.5,
            'horometro_compra' => 0,
            'horometro_ultimo_mantenimiento' => 1000,
            'horometro_proximo_mantenimiento' => 1500,
            'tipo_combustible' => 'Diesel',
            'consumo_promedio' => 22.5,
            'capacidad_tanque' => 400,
            'peso_operativo' => 22.5,
            'capacidad_carga' => 1.2,
            'unidad_capacidad' => 'm³',
            'licencia_requerida' => 'Licencia tipo D',
            'ultimo_servicio_fecha' => '2025-02-15',
            'proximo_servicio_fecha' => '2025-05-15'
        ]);

        $excavadora2 = Activo::create([
            'codigo' => 'EX-002',
            'nombre' => 'Excavadora Caterpillar 320D',
            'tipo_activo' => 'maquinaria',
            'categoria' => 'Excavadora',
            'marca' => 'Caterpillar',
            'modelo' => '320D',
            'serie' => 'CAT320D-2022-002',
            'anio' => 2022,
            'color' => 'Amarillo',
            'ubicacion_fisica' => 'Almacén Central - Zona A',
            'estado_general' => 'Excelente',
            'estatus' => 'Disponible',
            'fecha_adquisicion' => '2022-08-20',
            'costo_adquisicion' => 3500000,
            'valor_actual' => 2950000,
            'cuenta_contable' => '1150-03-01-002',
            'descripcion' => 'Excavadora de orugas para movimiento de tierra',
            'created_by' => $usuarioId
        ]);

        ActivoMaquinaria::create([
            'activo_id' => $excavadora2->id,
            'horometro_actual' => 980.0,
            'horometro_compra' => 0,
            'horometro_ultimo_mantenimiento' => 800,
            'horometro_proximo_mantenimiento' => 1300,
            'tipo_combustible' => 'Diesel',
            'consumo_promedio' => 22.5,
            'capacidad_tanque' => 400,
            'peso_operativo' => 22.5,
            'capacidad_carga' => 1.2,
            'unidad_capacidad' => 'm³',
            'licencia_requerida' => 'Licencia tipo D',
            'ultimo_servicio_fecha' => '2025-03-10'
        ]);

        $excavadora3 = Activo::create([
            'codigo' => 'EX-003',
            'nombre' => 'Excavadora Komatsu PC200',
            'tipo_activo' => 'maquinaria',
            'categoria' => 'Excavadora',
            'marca' => 'Komatsu',
            'modelo' => 'PC200',
            'serie' => 'KOM-PC200-2021-001',
            'anio' => 2021,
            'color' => 'Amarillo',
            'ubicacion_fisica' => 'Almacén Norte - Zona B',
            'proyecto_asignado_id' => $proyecto2->id,
            'fecha_asignacion' => '2025-02-15',
            'estado_general' => 'Regular',
            'estatus' => 'Asignado',
            'fecha_adquisicion' => '2021-10-10',
            'costo_adquisicion' => 3200000,
            'valor_actual' => 2100000,
            'cuenta_contable' => '1150-03-01-003',
            'descripcion' => 'Excavadora de orugas modelo PC200',
            'created_by' => $usuarioId
        ]);

        ActivoMaquinaria::create([
            'activo_id' => $excavadora3->id,
            'horometro_actual' => 2100.0,
            'horometro_compra' => 150,
            'horometro_ultimo_mantenimiento' => 2000,
            'horometro_proximo_mantenimiento' => 2200,
            'tipo_combustible' => 'Diesel',
            'consumo_promedio' => 20.5,
            'capacidad_tanque' => 380,
            'peso_operativo' => 20.8,
            'capacidad_carga' => 1.0,
            'unidad_capacidad' => 'm³',
            'licencia_requerida' => 'Licencia tipo D',
            'ultimo_servicio_fecha' => '2025-01-20',
            'proximo_servicio_fecha' => '2025-04-20'
        ]);

        // 2. Retroexcavadoras (Maquinaria)
        $retro1 = Activo::create([
            'codigo' => 'RT-001',
            'nombre' => 'Retroexcavadora John Deere 310L',
            'tipo_activo' => 'maquinaria',
            'categoria' => 'Retroexcavadora',
            'marca' => 'John Deere',
            'modelo' => '310L',
            'serie' => 'JD310L-2023-001',
            'anio' => 2023,
            'color' => 'Amarillo/Verde',
            'ubicacion_fisica' => 'Almacén Sur - Zona C',
            'proyecto_asignado_id' => $proyecto3->id,
            'fecha_asignacion' => '2025-03-10',
            'estado_general' => 'Excelente',
            'estatus' => 'Asignado',
            'fecha_adquisicion' => '2023-03-20',
            'costo_adquisicion' => 2800000,
            'valor_actual' => 2500000,
            'cuenta_contable' => '1150-03-02-001',
            'descripcion' => 'Retroexcavadora con cargador frontal',
            'created_by' => $usuarioId
        ]);

        ActivoMaquinaria::create([
            'activo_id' => $retro1->id,
            'horometro_actual' => 560.0,
            'horometro_compra' => 0,
            'horometro_ultimo_mantenimiento' => 500,
            'horometro_proximo_mantenimiento' => 1000,
            'tipo_combustible' => 'Diesel',
            'consumo_promedio' => 18.5,
            'capacidad_tanque' => 250,
            'peso_operativo' => 8.5,
            'capacidad_carga' => 1.5,
            'unidad_capacidad' => 'm³',
            'licencia_requerida' => 'Licencia tipo D',
            'ultimo_servicio_fecha' => '2025-03-01'
        ]);

        $retro2 = Activo::create([
            'codigo' => 'RT-002',
            'nombre' => 'Retroexcavadora Case 580SN',
            'tipo_activo' => 'maquinaria',
            'categoria' => 'Retroexcavadora',
            'marca' => 'Case',
            'modelo' => '580SN',
            'serie' => 'CAS580SN-2022-001',
            'anio' => 2022,
            'color' => 'Rojo/Negro',
            'ubicacion_fisica' => 'Almacén Central - Zona A',
            'proyecto_asignado_id' => $proyecto1->id,
            'fecha_asignacion' => '2025-02-20',
            'estado_general' => 'Bueno',
            'estatus' => 'Asignado',
            'fecha_adquisicion' => '2022-11-15',
            'costo_adquisicion' => 2600000,
            'valor_actual' => 2000000,
            'cuenta_contable' => '1150-03-02-002',
            'descripcion' => 'Retroexcavadora Case 580SN',
            'created_by' => $usuarioId
        ]);

        ActivoMaquinaria::create([
            'activo_id' => $retro2->id,
            'horometro_actual' => 1120.0,
            'horometro_compra' => 0,
            'horometro_ultimo_mantenimiento' => 1000,
            'horometro_proximo_mantenimiento' => 1500,
            'tipo_combustible' => 'Diesel',
            'consumo_promedio' => 17.5,
            'capacidad_tanque' => 240,
            'peso_operativo' => 8.2,
            'capacidad_carga' => 1.4,
            'unidad_capacidad' => 'm³',
            'licencia_requerida' => 'Licencia tipo D',
            'ultimo_servicio_fecha' => '2025-02-10'
        ]);

        // 3. Vehículos
        $camioneta1 = Activo::create([
            'codigo' => 'VEH-001',
            'nombre' => 'Camioneta RAM 2500',
            'tipo_activo' => 'vehiculo',
            'categoria' => 'Camioneta de carga',
            'marca' => 'RAM',
            'modelo' => '2500',
            'serie' => 'RAM2500-2023-001',
            'anio' => 2023,
            'color' => 'Blanco',
            'ubicacion_fisica' => 'Estacionamiento Principal',
            'proyecto_asignado_id' => $proyecto1->id,
            'fecha_asignacion' => '2025-03-01',
            'estado_general' => 'Excelente',
            'estatus' => 'Asignado',
            'fecha_adquisicion' => '2023-05-10',
            'costo_adquisicion' => 950000,
            'valor_actual' => 850000,
            'cuenta_contable' => '1150-05-01-001',
            'descripcion' => 'Camioneta de carga para transporte de materiales',
            'created_by' => $usuarioId
        ]);

        ActivoVehiculo::create([
            'activo_id' => $camioneta1->id,
            'placas' => 'ABC-1234',
            'numero_economico' => 'CAM-001',
            'vin' => '3C6UR5FL3PG123456',
            'kilometraje_actual' => 18500,
            'kilometraje_compra' => 0,
            'kilometraje_ultimo_mantenimiento' => 15000,
            'kilometraje_proximo_mantenimiento' => 20000,
            'tipo_combustible' => 'Diesel',
            'consumo_promedio' => 8.5,
            'capacidad_tanque' => 98,
            'capacidad_pasajeros' => 5,
            'capacidad_carga' => 1200,
            'tipo_vehiculo' => 'Pickup',
            'traccion' => '4x4',
            'transmision' => 'Automática',
            'poliza_seguro' => 'SEG-001',
            'vencimiento_seguro' => '2025-12-31',
            'poliza_verificacion' => 'VER-001',
            'vencimiento_verificacion' => '2025-06-30',
            'licencia_requerida' => 'Licencia tipo B',
            'ultimo_servicio_fecha' => '2025-02-15'
        ]);

        $camion = Activo::create([
            'codigo' => 'VEH-002',
            'nombre' => 'Camión de carga Mercedes Benz',
            'tipo_activo' => 'vehiculo',
            'categoria' => 'Camión de carga',
            'marca' => 'Mercedes Benz',
            'modelo' => 'Atego 1725',
            'serie' => 'MB-ATE-2022-001',
            'anio' => 2022,
            'color' => 'Blanco',
            'ubicacion_fisica' => 'Estacionamiento de Bodegas',
            'estado_general' => 'Bueno',
            'estatus' => 'Disponible',
            'fecha_adquisicion' => '2022-09-15',
            'costo_adquisicion' => 1800000,
            'valor_actual' => 1400000,
            'cuenta_contable' => '1150-05-02-001',
            'descripcion' => 'Camión de carga para transporte de materiales pesados',
            'created_by' => $usuarioId
        ]);

        ActivoVehiculo::create([
            'activo_id' => $camion->id,
            'placas' => 'XYZ-5678',
            'numero_economico' => 'CAM-002',
            'vin' => 'WDB1234567890ABC',
            'kilometraje_actual' => 45000,
            'kilometraje_compra' => 5000,
            'kilometraje_ultimo_mantenimiento' => 40000,
            'kilometraje_proximo_mantenimiento' => 50000,
            'tipo_combustible' => 'Diesel',
            'consumo_promedio' => 5.5,
            'capacidad_tanque' => 300,
            'capacidad_pasajeros' => 3,
            'capacidad_carga' => 8000,
            'tipo_vehiculo' => 'Camión',
            'traccion' => '6x2',
            'transmision' => 'Manual',
            'poliza_seguro' => 'SEG-002',
            'vencimiento_seguro' => '2025-10-31',
            'poliza_verificacion' => 'VER-002',
            'vencimiento_verificacion' => '2025-05-31',
            'licencia_requerida' => 'Licencia tipo C',
            'ultimo_servicio_fecha' => '2025-01-20',
            'proximo_servicio_fecha' => '2025-04-20'
        ]);

        // 4. Herramientas
        $soldadora = Activo::create([
            'codigo' => 'HER-001',
            'nombre' => 'Soldadora Lincoln Electric 220',
            'tipo_activo' => 'herramienta',
            'categoria' => 'Soldadora',
            'marca' => 'Lincoln Electric',
            'modelo' => 'Power MIG 210 MP',
            'serie' => 'LIN-MIG-001',
            'anio' => 2023,
            'color' => 'Rojo',
            'ubicacion_fisica' => 'Taller de Herramientas',
            'estado_general' => 'Excelente',
            'estatus' => 'Disponible',
            'fecha_adquisicion' => '2023-08-20',
            'costo_adquisicion' => 35000,
            'valor_actual' => 30000,
            'cuenta_contable' => '1150-04-01-001',
            'descripcion' => 'Soldadora inverter multifunción',
            'created_by' => $usuarioId
        ]);

        ActivoHerramienta::create([
            'activo_id' => $soldadora->id,
            'tipo_herramienta' => 'Soldadora eléctrica',
            'voltaje' => '220V',
            'potencia' => 5.5,
            'requiere_calibracion' => true,
            'fecha_ultima_calibracion' => '2025-01-15',
            'fecha_proxima_calibracion' => '2026-01-15',
            'numero_inventario' => 'INV-HER-001',
            'prestamos_realizados' => 5,
            'tiempo_uso_promedio' => 4.5
        ]);

        $taladro = Activo::create([
            'codigo' => 'HER-002',
            'nombre' => 'Taladro Percutor Bosch GBH 2-26',
            'tipo_activo' => 'herramienta',
            'categoria' => 'Taladro',
            'marca' => 'Bosch',
            'modelo' => 'GBH 2-26',
            'serie' => 'BOS-GBH-001',
            'anio' => 2024,
            'color' => 'Azul',
            'ubicacion_fisica' => 'Taller de Herramientas',
            'estado_general' => 'Excelente',
            'estatus' => 'Disponible',
            'fecha_adquisicion' => '2024-01-10',
            'costo_adquisicion' => 8500,
            'valor_actual' => 8000,
            'cuenta_contable' => '1150-04-01-002',
            'descripcion' => 'Taladro percutor rotomartillo',
            'created_by' => $usuarioId
        ]);

        ActivoHerramienta::create([
            'activo_id' => $taladro->id,
            'tipo_herramienta' => 'Taladro eléctrico',
            'voltaje' => '120V',
            'potencia' => 1.2,
            'requiere_calibracion' => false,
            'numero_inventario' => 'INV-HER-002',
            'prestamos_realizados' => 3,
            'tiempo_uso_promedio' => 2.5
        ]);

        // ============================================
        // REQUISICIONES DE ACTIVOS
        // ============================================

        $requisicion1 = RequisicionActivo::create([
            'folio' => 'REQ-00001',
            'proyecto_id' => $proyecto1->id,
            'activo_id' => $excavadora1->id,
            'cantidad' => 1,
            'fecha_requisicion' => '2025-03-01',
            'fecha_requerida' => '2025-03-05',
            'solicitante' => 'Juan Pérez',
            'area' => 'Operaciones',
            'prioridad' => 'Alta',
            'motivo' => 'Excavación para cimentación de torre',
            'observaciones' => 'Se requiere para inicio de obra',
            'estatus' => 'Asignada',
            'autorizado_por' => $usuarioId,
            'fecha_autorizacion' => '2025-03-02',
            'creado_por' => $usuarioId
        ]);

        $requisicion2 = RequisicionActivo::create([
            'folio' => 'REQ-00002',
            'proyecto_id' => $proyecto2->id,
            'activo_id' => $excavadora3->id,
            'cantidad' => 1,
            'fecha_requisicion' => '2025-03-05',
            'fecha_requerida' => '2025-03-10',
            'solicitante' => 'María García',
            'area' => 'Construcción',
            'prioridad' => 'Media',
            'motivo' => 'Movimiento de tierra para puente',
            'observaciones' => 'Trabajo en zona de difícil acceso',
            'estatus' => 'Asignada',
            'autorizado_por' => $usuarioId,
            'fecha_autorizacion' => '2025-03-06',
            'creado_por' => $usuarioId
        ]);

        $requisicion3 = RequisicionActivo::create([
            'folio' => 'REQ-00003',
            'proyecto_id' => $proyecto3->id,
            'activo_id' => $retro1->id,
            'cantidad' => 1,
            'fecha_requisicion' => '2025-03-08',
            'fecha_requerida' => '2025-03-12',
            'solicitante' => 'Carlos López',
            'area' => 'Terracerías',
            'prioridad' => 'Alta',
            'motivo' => 'Preparación de terreno para parque industrial',
            'observaciones' => 'Se requiere con urgencia',
            'estatus' => 'Asignada',
            'autorizado_por' => $usuarioId,
            'fecha_autorizacion' => '2025-03-09',
            'creado_por' => $usuarioId
        ]);

        $requisicion4 = RequisicionActivo::create([
            'folio' => 'REQ-00004',
            'proyecto_id' => $proyecto1->id,
            'activo_id' => $camioneta1->id,
            'cantidad' => 1,
            'fecha_requisicion' => '2025-03-10',
            'fecha_requerida' => '2025-03-15',
            'solicitante' => 'Ana Martínez',
            'area' => 'Logística',
            'prioridad' => 'Baja',
            'motivo' => 'Transporte de materiales a obra',
            'estatus' => 'Pendiente',
            'creado_por' => $usuarioId
        ]);

        $requisicion5 = RequisicionActivo::create([
            'folio' => 'REQ-00005',
            'proyecto_id' => $proyecto2->id,
            'activo_id' => $soldadora->id,
            'cantidad' => 1,
            'fecha_requisicion' => '2025-03-12',
            'fecha_requerida' => '2025-03-18',
            'solicitante' => 'Roberto Sánchez',
            'area' => 'Estructuras',
            'prioridad' => 'Media',
            'motivo' => 'Soldadura de vigas metálicas',
            'observaciones' => 'Se requiere para unión de estructuras',
            'estatus' => 'Pendiente',
            'creado_por' => $usuarioId
        ]);

        // ============================================
        // ASIGNACIONES (SALIDAS)
        // ============================================

        AsignacionActivo::create([
            'requisicion_id' => $requisicion1->id,
            'activo_id' => $excavadora1->id,
            'proyecto_id' => $proyecto1->id,
            'responsable_asignado' => 'Juan Pérez',
            'fecha_salida' => '2025-03-03',
            'horometro_salida' => 1245.5,
            'condicion_salida' => 'Bueno',
            'observaciones_salida' => 'Entrega en sitio de obra',
            'estatus' => 'Activa'
        ]);

        AsignacionActivo::create([
            'requisicion_id' => $requisicion2->id,
            'activo_id' => $excavadora3->id,
            'proyecto_id' => $proyecto2->id,
            'responsable_asignado' => 'María García',
            'fecha_salida' => '2025-03-07',
            'horometro_salida' => 2100.0,
            'condicion_salida' => 'Regular',
            'observaciones_salida' => 'Requiere mantenimiento próximo',
            'estatus' => 'Activa'
        ]);

        AsignacionActivo::create([
            'requisicion_id' => $requisicion3->id,
            'activo_id' => $retro1->id,
            'proyecto_id' => $proyecto3->id,
            'responsable_asignado' => 'Carlos López',
            'fecha_salida' => '2025-03-10',
            'horometro_salida' => 560.0,
            'condicion_salida' => 'Excelente',
            'observaciones_salida' => 'Equipo nuevo',
            'estatus' => 'Activa'
        ]);

        // Devolución completada
        AsignacionActivo::create([
            'requisicion_id' => null,
            'activo_id' => $camion->id,
            'proyecto_id' => $proyecto1->id,
            'responsable_asignado' => 'Fernando González',
            'fecha_salida' => '2025-02-01',
            'fecha_devolucion_real' => '2025-02-28',
            'kilometraje_salida' => 45000,
            'kilometraje_devolucion' => 48500,
            'condicion_salida' => 'Bueno',
            'condicion_devolucion' => 'Bueno',
            'observaciones_salida' => 'Préstamo para transporte',
            'observaciones_devolucion' => 'Devuelto en buen estado',
            'estatus' => 'Devuelta',
            'recibido_por' => $usuarioId
        ]);

        // Reactivar constraints
        DB::statement('SET CONSTRAINTS ALL IMMEDIATE');

        $this->command->info('✅ Activos creados: ' . Activo::count());
        $this->command->info('   - Maquinaria: ' . Activo::where('tipo_activo', 'maquinaria')->count());
        $this->command->info('   - Vehículos: ' . Activo::where('tipo_activo', 'vehiculo')->count());
        $this->command->info('   - Herramientas: ' . Activo::where('tipo_activo', 'herramienta')->count());
        $this->command->info('✅ Requisiciones creadas: ' . RequisicionActivo::count());
        $this->command->info('✅ Asignaciones creadas: ' . AsignacionActivo::count());
    }
}