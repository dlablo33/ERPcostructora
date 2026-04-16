<?php
// database/seeders/EstadoResultadosSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadoResultadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // 1. LIMPIAR TABLAS EXISTENTES (PostgreSQL)
        // ==========================================
        DB::statement('TRUNCATE TABLE movimientos_bancarios RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE proyecto_flujo_efectivo RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE proyecto_saldos RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE proyecto_costos RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE proyectos RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE categorias_gastos RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE tipos_egreso RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE tipos_ingreso RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE cuentas_bancarias RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE bancos RESTART IDENTITY CASCADE');
        
        // ==========================================
        // 2. CREAR O OBTENER USUARIO POR DEFECTO
        // ==========================================
        $defaultUserId = null;
        
        // Verificar si existe la tabla users
        $tableExists = DB::select("SELECT to_regclass('public.users')");
        
        if ($tableExists && reset($tableExists)->to_regclass) {
            // Buscar un usuario existente
            $user = DB::table('users')->first();
            if ($user) {
                $defaultUserId = $user->id;
                $this->command->info("✅ Usuario encontrado: ID {$defaultUserId}");
            } else {
                // Crear usuario por defecto si no existe ninguno
                $defaultUserId = DB::table('users')->insertGetId([
                    'name' => 'Sistema',
                    'email' => 'sistema@constructora.com',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->command->info("✅ Usuario creado: ID {$defaultUserId}");
            }
        } else {
            // Si no existe la tabla users, usar un valor temporal
            $defaultUserId = 1;
            $this->command->warn("⚠️ Tabla users no encontrada, usando ID: {$defaultUserId}");
        }

        // ==========================================
        // 3. CREAR MONEDA
        // ==========================================
        $monedaId = null;
        try {
            $moneda = DB::table('monedas')->first();
            if ($moneda) {
                $monedaId = $moneda->id;
            } else {
                $monedaId = DB::table('monedas')->insertGetId([
                    'nombre' => 'Peso Mexicano',
                    'codigo' => 'MXN',
                    'simbolo' => '$',
                    'activa' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            $monedaId = 1;
            $this->command->warn("⚠️ No se pudo crear moneda, usando ID: {$monedaId}");
        }

        // ==========================================
        // 4. TIPOS DE INGRESO
        // ==========================================
        $tiposIngreso = [
            ['nombre' => 'Estimación de Obra', 'descripcion' => 'Pago por avance de obra', 'activo' => true],
            ['nombre' => 'Anticipo', 'descripcion' => 'Anticipo de cliente', 'activo' => true],
            ['nombre' => 'Finiquito', 'descripcion' => 'Pago final de obra', 'activo' => true],
            ['nombre' => 'Penalización', 'descripcion' => 'Pago por penalización a proveedor', 'activo' => true],
            ['nombre' => 'Intereses', 'descripcion' => 'Intereses bancarios', 'activo' => true],
            ['nombre' => 'Venta de Activos', 'descripcion' => 'Venta de maquinaria o equipo', 'activo' => true],
        ];
        
        foreach ($tiposIngreso as $tipo) {
            DB::table('tipos_ingreso')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'activo' => $tipo['activo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info("✅ Tipos de ingreso creados");

        // ==========================================
        // 5. TIPOS DE EGRESO
        // ==========================================
        $tiposEgreso = [
            ['nombre' => 'Materiales', 'descripcion' => 'Materiales de construcción', 'activo' => true],
            ['nombre' => 'Mano de Obra', 'descripcion' => 'Personal de obra', 'activo' => true],
            ['nombre' => 'Maquinaria y Equipo', 'descripcion' => 'Renta y operación de maquinaria', 'activo' => true],
            ['nombre' => 'Subcontratos', 'descripcion' => 'Servicios subcontratados', 'activo' => true],
            ['nombre' => 'Gastos Indirectos', 'descripcion' => 'Gastos administrativos de obra', 'activo' => true],
            ['nombre' => 'Gastos Financieros', 'descripcion' => 'Intereses y comisiones', 'activo' => true],
            ['nombre' => 'Impuestos', 'descripcion' => 'Pagos de impuestos', 'activo' => true],
        ];
        
        foreach ($tiposEgreso as $tipo) {
            DB::table('tipos_egreso')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'activo' => $tipo['activo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info("✅ Tipos de egreso creados");

        // ==========================================
        // 6. CATEGORÍAS DE GASTOS
        // ==========================================
        $categoriasGasto = [
            ['nombre' => 'Concreto', 'descripcion' => 'Concreto premezclado', 'tipo_egreso_id' => 1, 'activo' => true],
            ['nombre' => 'Acero', 'descripcion' => 'Varilla, acero de refuerzo', 'tipo_egreso_id' => 1, 'activo' => true],
            ['nombre' => 'Block y Ladrillo', 'descripcion' => 'Materiales de mampostería', 'tipo_egreso_id' => 1, 'activo' => true],
            ['nombre' => 'Albañiles', 'descripcion' => 'Cuadrilla de albañiles', 'tipo_egreso_id' => 2, 'activo' => true],
            ['nombre' => 'Electricistas', 'descripcion' => 'Cuadrilla de electricistas', 'tipo_egreso_id' => 2, 'activo' => true],
            ['nombre' => 'Plomeros', 'descripcion' => 'Cuadrilla de plomeros', 'tipo_egreso_id' => 2, 'activo' => true],
            ['nombre' => 'Maquinaria Pesada', 'descripcion' => 'Excavadoras, retroexcavadoras', 'tipo_egreso_id' => 3, 'activo' => true],
            ['nombre' => 'Herramienta Menor', 'descripcion' => 'Taladros, pulidoras', 'tipo_egreso_id' => 3, 'activo' => true],
            ['nombre' => 'Combustible', 'descripcion' => 'Diesel, gasolina', 'tipo_egreso_id' => 3, 'activo' => true],
            ['nombre' => 'Instalaciones Especiales', 'descripcion' => 'Subcontratos', 'tipo_egreso_id' => 4, 'activo' => true],
            ['nombre' => 'Renta de Oficinas', 'descripcion' => 'Oficinas de obra', 'tipo_egreso_id' => 5, 'activo' => true],
            ['nombre' => 'Servicios', 'descripcion' => 'Luz, agua, internet', 'tipo_egreso_id' => 5, 'activo' => true],
            ['nombre' => 'Viáticos', 'descripcion' => 'Alimentos, hospedaje', 'tipo_egreso_id' => 5, 'activo' => true],
        ];
        
        foreach ($categoriasGasto as $categoria) {
            DB::table('categorias_gastos')->insert([
                'nombre' => $categoria['nombre'],
                'descripcion' => $categoria['descripcion'],
                'tipo_egreso_id' => $categoria['tipo_egreso_id'],
                'activo' => $categoria['activo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info("✅ Categorías de gastos creadas");

        // ==========================================
        // 7. BANCOS
        // ==========================================
        $bancos = [
            ['nombre' => 'BBVA', 'codigo' => '012', 'activo' => true],
            ['nombre' => 'Santander', 'codigo' => '014', 'activo' => true],
            ['nombre' => 'Banamex', 'codigo' => '002', 'activo' => true],
            ['nombre' => 'HSBC', 'codigo' => '021', 'activo' => true],
            ['nombre' => 'Banorte', 'codigo' => '072', 'activo' => true],
        ];
        
        foreach ($bancos as $banco) {
            DB::table('bancos')->insert([
                'nombre' => $banco['nombre'],
                'codigo' => $banco['codigo'],
                'activo' => $banco['activo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info("✅ Bancos creados");

        // ==========================================
        // 8. CUENTAS BANCARIAS
        // ==========================================
        $cuentas = [
            [
                'banco_id' => 1, 
                'moneda_id' => $monedaId,
                'numero_cuenta' => '1234567890123456', 
                'clabe' => '012180123456789012', 
                'titular' => 'Constructora ABC', 
                'tipo_cuenta' => 'cheques', 
                'saldo_inicial' => 1500000, 
                'saldo_actual' => 1500000, 
                'activa' => true
            ],
            [
                'banco_id' => 2, 
                'moneda_id' => $monedaId,
                'numero_cuenta' => '5678901234567890', 
                'clabe' => '014180987654321098', 
                'titular' => 'Constructora ABC', 
                'tipo_cuenta' => 'cheques', 
                'saldo_inicial' => 800000, 
                'saldo_actual' => 800000, 
                'activa' => true
            ],
            [
                'banco_id' => 3, 
                'moneda_id' => $monedaId,
                'numero_cuenta' => '9012345678901234', 
                'clabe' => '002180456789123456', 
                'titular' => 'Constructora ABC', 
                'tipo_cuenta' => 'ahorros', 
                'saldo_inicial' => 500000, 
                'saldo_actual' => 500000, 
                'activa' => true
            ],
        ];
        
        foreach ($cuentas as $cuenta) {
            DB::table('cuentas_bancarias')->insert([
                'banco_id' => $cuenta['banco_id'],
                'moneda_id' => $cuenta['moneda_id'],
                'numero_cuenta' => $cuenta['numero_cuenta'],
                'clabe' => $cuenta['clabe'],
                'titular' => $cuenta['titular'],
                'tipo_cuenta' => $cuenta['tipo_cuenta'],
                'saldo_inicial' => $cuenta['saldo_inicial'],
                'saldo_actual' => $cuenta['saldo_actual'],
                'activa' => $cuenta['activa'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info("✅ Cuentas bancarias creadas");

        // ==========================================
        // 9. PROYECTOS (con todos los campos y created_by no nulo)
        // ==========================================
        $proyectos = [
            [
                'codigo' => 'PRO-2026-001',
                'nombre' => 'Torre Norte Corporativa',
                'tipo_proyecto' => 'Construcción',
                'categoria' => 'Edificio Corporativo',
                'prioridad' => 'alta',
                'ubicacion' => 'Av. Reforma 123, CDMX',
                'direccion' => 'Av. Reforma 123, Col. Centro, CDMX',
                'fecha_inicio' => '2026-01-10',
                'fecha_fin' => '2026-12-20',
                'descripcion' => 'Construcción de torre corporativa de 20 pisos',
                'estado' => 'en_curso',
                'moneda' => 'MXN',
                'tipo_cambio' => 1.00,
                'cliente_nombre' => 'Grupo Inmobiliario del Norte',
                'cliente_rfc' => 'GIN850101XXX',
                'cliente_email' => 'contacto@gin.com',
                'cliente_telefono' => '5551234567',
                'cliente_contacto' => 'Juan Pérez',
                'cliente_cargo' => 'Director',
                'numero_contrato' => 'CONT-001-2026',
                'fecha_firma' => '2026-01-05',
                'tipo_contrato' => 'Obra determinada',
                'forma_pago' => 'Estimaciones mensuales',
                'plazo_pago' => 30,
                'responsable_id' => null,
                'cargo_responsable' => 'Director de Proyectos',
                'email_responsable' => 'proyectos@constructora.com',
                'presupuesto_total' => 12500000,
                'anticipo' => 20.00,
                'margen' => 25.00,
                'fondo_reserva' => 5.00,
                'status' => 'activo',
                'created_by' => $defaultUserId,
            ],
            [
                'codigo' => 'PRO-2026-002',
                'nombre' => 'Hospital Regional',
                'tipo_proyecto' => 'Salud',
                'categoria' => 'Hospital',
                'prioridad' => 'alta',
                'ubicacion' => 'Blvd. Miguel Alemán 456, Toluca',
                'direccion' => 'Blvd. Miguel Alemán 456, Col. Centro, Toluca',
                'fecha_inicio' => '2026-02-01',
                'fecha_fin' => '2027-03-15',
                'descripcion' => 'Construcción de hospital regional de 3 niveles',
                'estado' => 'en_curso',
                'moneda' => 'MXN',
                'tipo_cambio' => 1.00,
                'cliente_nombre' => 'Servicios de Salud del Estado',
                'cliente_rfc' => 'SSE860101XXX',
                'cliente_email' => 'compras@salud.gob.mx',
                'cliente_telefono' => '7221234567',
                'cliente_contacto' => 'María López',
                'cliente_cargo' => 'Directora',
                'numero_contrato' => 'CONT-002-2026',
                'fecha_firma' => '2026-01-20',
                'tipo_contrato' => 'Obra determinada',
                'forma_pago' => 'Estimaciones mensuales',
                'plazo_pago' => 45,
                'responsable_id' => null,
                'cargo_responsable' => 'Gerente de Proyectos',
                'email_responsable' => 'gerencia@constructora.com',
                'presupuesto_total' => 18500000,
                'anticipo' => 20.00,
                'margen' => 22.00,
                'fondo_reserva' => 5.00,
                'status' => 'activo',
                'created_by' => $defaultUserId,
            ],
            [
                'codigo' => 'PRO-2026-003',
                'nombre' => 'Parque Industrial Norte',
                'tipo_proyecto' => 'Industrial',
                'categoria' => 'Parque Industrial',
                'prioridad' => 'media',
                'ubicacion' => 'Carretera a Querétaro Km 25, Cuautitlán',
                'direccion' => 'Carretera a Querétaro Km 25, Cuautitlán',
                'fecha_inicio' => '2026-01-15',
                'fecha_fin' => '2026-09-30',
                'descripcion' => 'Construcción de naves industriales',
                'estado' => 'en_curso',
                'moneda' => 'MXN',
                'tipo_cambio' => 1.00,
                'cliente_nombre' => 'Desarrollos Industriales del Norte',
                'cliente_rfc' => 'DIN870101XXX',
                'cliente_email' => 'info@din.mx',
                'cliente_telefono' => '5559876543',
                'cliente_contacto' => 'Carlos Ruiz',
                'cliente_cargo' => 'Gerente',
                'numero_contrato' => 'CONT-003-2026',
                'fecha_firma' => '2026-01-10',
                'tipo_contrato' => 'Obra determinada',
                'forma_pago' => 'Estimaciones mensuales',
                'plazo_pago' => 30,
                'responsable_id' => null,
                'cargo_responsable' => 'Coordinador de Proyectos',
                'email_responsable' => 'coordinacion@constructora.com',
                'presupuesto_total' => 9500000,
                'anticipo' => 15.00,
                'margen' => 20.00,
                'fondo_reserva' => 5.00,
                'status' => 'activo',
                'created_by' => $defaultUserId,
            ],
            [
                'codigo' => 'PRO-2026-004',
                'nombre' => 'Puente Vehicular Sur',
                'tipo_proyecto' => 'Infraestructura',
                'categoria' => 'Puente',
                'prioridad' => 'alta',
                'ubicacion' => 'Periférico Sur 789, CDMX',
                'direccion' => 'Periférico Sur 789, CDMX',
                'fecha_inicio' => '2026-03-01',
                'fecha_fin' => '2026-11-30',
                'descripcion' => 'Construcción de puente vehicular',
                'estado' => 'en_curso',
                'moneda' => 'MXN',
                'tipo_cambio' => 1.00,
                'cliente_nombre' => 'Gobierno del Estado',
                'cliente_rfc' => 'GES880101XXX',
                'cliente_email' => 'obrapublica@estado.gob.mx',
                'cliente_telefono' => '5554567890',
                'cliente_contacto' => 'Ana García',
                'cliente_cargo' => 'Directora',
                'numero_contrato' => 'CONT-004-2026',
                'fecha_firma' => '2026-02-15',
                'tipo_contrato' => 'Obra determinada',
                'forma_pago' => 'Estimaciones mensuales',
                'plazo_pago' => 60,
                'responsable_id' => null,
                'cargo_responsable' => 'Superintendente',
                'email_responsable' => 'superintendencia@constructora.com',
                'presupuesto_total' => 7200000,
                'anticipo' => 25.00,
                'margen' => 18.00,
                'fondo_reserva' => 5.00,
                'status' => 'activo',
                'created_by' => $defaultUserId,
            ],
            [
                'codigo' => 'PRO-2026-005',
                'nombre' => 'Centro Comercial Los Pinos',
                'tipo_proyecto' => 'Comercial',
                'categoria' => 'Centro Comercial',
                'prioridad' => 'media',
                'ubicacion' => 'Av. Universidad 234, Querétaro',
                'direccion' => 'Av. Universidad 234, Querétaro',
                'fecha_inicio' => '2026-02-15',
                'fecha_fin' => '2027-01-31',
                'descripcion' => 'Construcción de centro comercial',
                'estado' => 'en_curso',
                'moneda' => 'MXN',
                'tipo_cambio' => 1.00,
                'cliente_nombre' => 'Inmobiliaria Los Pinos',
                'cliente_rfc' => 'ILP890101XXX',
                'cliente_email' => 'contacto@ilp.mx',
                'cliente_telefono' => '4421234567',
                'cliente_contacto' => 'Roberto Sánchez',
                'cliente_cargo' => 'Director',
                'numero_contrato' => 'CONT-005-2026',
                'fecha_firma' => '2026-02-01',
                'tipo_contrato' => 'Obra determinada',
                'forma_pago' => 'Estimaciones mensuales',
                'plazo_pago' => 30,
                'responsable_id' => null,
                'cargo_responsable' => 'Gerente de Proyectos',
                'email_responsable' => 'gerencia@constructora.com',
                'presupuesto_total' => 15300000,
                'anticipo' => 15.00,
                'margen' => 25.00,
                'fondo_reserva' => 5.00,
                'status' => 'activo',
                'created_by' => $defaultUserId,
            ],
        ];
        
        foreach ($proyectos as $proyecto) {
            DB::table('proyectos')->insert(array_merge($proyecto, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
        $this->command->info("✅ Proyectos creados");

        // ==========================================
        // 10. COSTOS POR PROYECTO
        // ==========================================
        $proyectosDB = DB::table('proyectos')->get();
        
        $costosProyectos = [
            1 => ['materiales' => 4200000, 'mano_obra' => 3200000, 'maquinaria' => 1800000, 'subcontratos' => 1500000, 'gastos_indirectos' => 1800000],
            2 => ['materiales' => 6200000, 'mano_obra' => 4800000, 'maquinaria' => 2500000, 'subcontratos' => 2200000, 'gastos_indirectos' => 2800000],
            3 => ['materiales' => 3200000, 'mano_obra' => 2400000, 'maquinaria' => 1300000, 'subcontratos' => 1100000, 'gastos_indirectos' => 1500000],
            4 => ['materiales' => 2400000, 'mano_obra' => 1800000, 'maquinaria' => 1000000, 'subcontratos' => 800000, 'gastos_indirectos' => 1200000],
            5 => ['materiales' => 5100000, 'mano_obra' => 3900000, 'maquinaria' => 2100000, 'subcontratos' => 1800000, 'gastos_indirectos' => 2400000],
        ];
        
        foreach ($proyectosDB as $proyecto) {
            $costos = $costosProyectos[$proyecto->id] ?? $costosProyectos[1];
            DB::table('proyecto_costos')->insert([
                'proyecto_id' => $proyecto->id,
                'materiales' => $costos['materiales'],
                'mano_obra' => $costos['mano_obra'],
                'maquinaria' => $costos['maquinaria'],
                'subcontratos' => $costos['subcontratos'],
                'gastos_indirectos' => $costos['gastos_indirectos'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info("✅ Costos de proyectos creados");

        // ==========================================
// 11. FLUJO DE EFECTIVO MENSUAL
// ==========================================
$flujoEfectivo = [
    1 => [1 => ['ingreso' => 1250000, 'gasto' => 850000]],
    2 => [2 => ['ingreso' => 1500000, 'gasto' => 1300000]],
    3 => [1 => ['ingreso' => 950000, 'gasto' => 600000]],
    4 => [3 => ['ingreso' => 800000, 'gasto' => 700000]],
    5 => [2 => ['ingreso' => 1200000, 'gasto' => 1100000]],
];

foreach ($proyectosDB as $proyecto) {
    $flujos = $flujoEfectivo[$proyecto->id] ?? [];
    foreach ($flujos as $mes => $valores) {
        $data = [
            'proyecto_id' => $proyecto->id,
            'mes' => $mes,
            'ingreso_estimado' => $valores['ingreso'],
            'gasto_estimado' => $valores['gasto'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Si la columna anio existe, agregarla
        // Primero verificar si existe la columna
        $columns = DB::getSchemaBuilder()->getColumnListing('proyecto_flujo_efectivo');
        if (in_array('anio', $columns)) {
            $data['anio'] = 2026;
        }
        
        // Si la columna año existe (con tilde)
        if (in_array('año', $columns)) {
            $data['año'] = 2026;
        }
        
        // Si la columna fecha existe
        if (in_array('fecha', $columns)) {
            $data['fecha'] = "2026-{$mes}-01";
        }
        
        DB::table('proyecto_flujo_efectivo')->insert($data);
    }
}
$this->command->info("✅ Flujo de efectivo creado");

        // ==========================================
        // 12. MOVIMIENTOS BANCARIOS
        // ==========================================
// ==========================================
// 12. MOVIMIENTOS BANCARIOS
// ==========================================

// ==========================================
// 12. MOVIMIENTOS BANCARIOS (VERSIÓN DINÁMICA)
// ==========================================

// Obtener las columnas reales de movimientos_bancarios
$movColumns = DB::getSchemaBuilder()->getColumnListing('movimientos_bancarios');
$this->command->info("Columnas en movimientos_bancarios: " . implode(', ', $movColumns));

// Usar el mismo usuario que creaste para los proyectos
$defaultUserId = DB::table('users')->first()->id ?? 1;

$metodoPagoId = null;
try {
    $metodoPago = DB::table('metodos_pago')->first();
    if ($metodoPago) {
        $metodoPagoId = $metodoPago->id;
    } else {
        $metodoPagoId = DB::table('metodos_pago')->insertGetId([
            'nombre' => 'Transferencia',
            'descripcion' => 'Transferencia bancaria',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
} catch (\Exception $e) {
    $metodoPagoId = 1;
}

$categoriasDB = DB::table('categorias_gastos')->get();
$categoriasPorNombre = [];
foreach ($categoriasDB as $cat) {
    $categoriasPorNombre[$cat->nombre] = $cat->id;
}

// Definir los movimientos base (sin filtrar)
$movimientosBase = [
    ['proyecto_id' => 1, 'cuenta_bancaria_id' => 1, 'tipo' => 'ingreso', 'tipo_ingreso_id' => 1, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 1250000, 'fecha' => '2026-01-15', 'concepto' => 'Estimación 1', 'status' => 'aplicado'],
    ['proyecto_id' => 1, 'cuenta_bancaria_id' => 1, 'tipo' => 'ingreso', 'tipo_ingreso_id' => 2, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 2500000, 'fecha' => '2026-01-05', 'concepto' => 'Anticipo', 'status' => 'aplicado'],
    ['proyecto_id' => 1, 'cuenta_bancaria_id' => 1, 'tipo' => 'egreso', 'categoria_gasto_id' => $categoriasPorNombre['Concreto'] ?? 1, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 85000, 'fecha' => '2026-01-08', 'concepto' => 'Concreto', 'status' => 'aplicado'],
    ['proyecto_id' => 1, 'cuenta_bancaria_id' => 1, 'tipo' => 'egreso', 'categoria_gasto_id' => $categoriasPorNombre['Acero'] ?? 2, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 120000, 'fecha' => '2026-01-10', 'concepto' => 'Acero', 'status' => 'aplicado'],
    ['proyecto_id' => 1, 'cuenta_bancaria_id' => 1, 'tipo' => 'egreso', 'categoria_gasto_id' => $categoriasPorNombre['Albañiles'] ?? 4, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 65000, 'fecha' => '2026-01-15', 'concepto' => 'Mano de obra', 'status' => 'aplicado'],
    ['proyecto_id' => 2, 'cuenta_bancaria_id' => 2, 'tipo' => 'ingreso', 'tipo_ingreso_id' => 2, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 3500000, 'fecha' => '2026-02-10', 'concepto' => 'Anticipo', 'status' => 'aplicado'],
    ['proyecto_id' => 2, 'cuenta_bancaria_id' => 2, 'tipo' => 'egreso', 'categoria_gasto_id' => $categoriasPorNombre['Concreto'] ?? 1, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 120000, 'fecha' => '2026-02-05', 'concepto' => 'Concreto', 'status' => 'aplicado'],
    ['proyecto_id' => 3, 'cuenta_bancaria_id' => 3, 'tipo' => 'ingreso', 'tipo_ingreso_id' => 1, 'metodo_pago_id' => $metodoPagoId, 'created_by' => $defaultUserId, 'monto' => 950000, 'fecha' => '2026-01-20', 'concepto' => 'Estimación 1', 'status' => 'aplicado'],
];

// Insertar solo las columnas que existen
foreach ($movimientosBase as $movimiento) {
    $filteredData = array_intersect_key($movimiento, array_flip($movColumns));
    $filteredData['created_at'] = now();
    $filteredData['updated_at'] = now();
    
    DB::table('movimientos_bancarios')->insert($filteredData);
}
$this->command->info("✅ Movimientos bancarios creados");
        // ==========================================
        // 13. SALDOS POR PROYECTO
        // ==========================================
        foreach ($proyectosDB as $proyecto) {
            $totalIngresos = DB::table('movimientos_bancarios')
                ->where('proyecto_id', $proyecto->id)
                ->where('tipo', 'ingreso')
                ->where('status', 'aplicado')
                ->sum('monto');
                
            $totalEgresos = DB::table('movimientos_bancarios')
                ->where('proyecto_id', $proyecto->id)
                ->where('tipo', 'egreso')
                ->where('status', 'aplicado')
                ->sum('monto');
            
            DB::table('proyecto_saldos')->insert([
                'proyecto_id' => $proyecto->id,
                'cuenta_bancaria_id' => 1,
                'saldo_asignado' => $proyecto->presupuesto_total,
                'saldo_disponible' => $proyecto->presupuesto_total - $totalEgresos,
                'total_ingresos' => $totalIngresos,
                'total_egresos' => $totalEgresos,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info("✅ Saldos de proyectos creados");

        $this->command->info('==========================================');
        $this->command->info('✅ ESTADO DE RESULTADOS SEEDER COMPLETADO');
        $this->command->info('==========================================');
    }
}