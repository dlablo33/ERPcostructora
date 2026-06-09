<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CodigoSat;
use App\Models\Proveedor;
use App\Models\Pago;
use App\Models\Deposito;
use App\Models\CuentaBancaria;
use App\Models\MovimientoBancario;
use App\Models\Facturacion\Contacto;
use App\Models\Proyecto;
use App\Models\TipoEgreso;
use App\Models\TipoIngreso;
use App\Models\MetodoPago;
use App\Models\Moneda;
use Carbon\Carbon;

class DatosCompletosEstadoResultadosSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('=========================================');
        $this->command->info('Creando datos completos para Estado de Resultados');
        $this->command->info('=========================================');

        // 1. CÓDIGOS SAT COMPLETOS
        $this->command->info('1. Creando códigos SAT...');
        
        $codigosSAT = [
            // ==================== INGRESOS (400-499) ====================
            ['codigo_agrupador' => '400', 'nivel' => 1, 'nombre_cuenta' => 'INGRESOS NETOS', 'tipo' => 'I'],
            ['codigo_agrupador' => '401', 'nivel' => 2, 'nombre_cuenta' => 'Ventas', 'tipo' => 'I'],
            ['codigo_agrupador' => '401.01', 'nivel' => 3, 'nombre_cuenta' => 'Ventas Nacionales', 'tipo' => 'I'],
            ['codigo_agrupador' => '401.02', 'nivel' => 3, 'nombre_cuenta' => 'Ventas Internacionales', 'tipo' => 'I'],
            ['codigo_agrupador' => '402', 'nivel' => 2, 'nombre_cuenta' => 'Prestación de Servicios', 'tipo' => 'I'],
            ['codigo_agrupador' => '402.01', 'nivel' => 3, 'nombre_cuenta' => 'Servicios Profesionales', 'tipo' => 'I'],
            ['codigo_agrupador' => '402.02', 'nivel' => 3, 'nombre_cuenta' => 'Servicios Técnicos', 'tipo' => 'I'],
            ['codigo_agrupador' => '403', 'nivel' => 2, 'nombre_cuenta' => 'Ingresos por Obras', 'tipo' => 'I'],
            ['codigo_agrupador' => '403.01', 'nivel' => 3, 'nombre_cuenta' => 'Obras Públicas', 'tipo' => 'I'],
            ['codigo_agrupador' => '403.02', 'nivel' => 3, 'nombre_cuenta' => 'Obras Privadas', 'tipo' => 'I'],
            ['codigo_agrupador' => '404', 'nivel' => 2, 'nombre_cuenta' => 'Arrendamiento', 'tipo' => 'I'],
            ['codigo_agrupador' => '405', 'nivel' => 2, 'nombre_cuenta' => 'Intereses a Favor', 'tipo' => 'I'],
            ['codigo_agrupador' => '406', 'nivel' => 2, 'nombre_cuenta' => 'Otros Ingresos', 'tipo' => 'I'],
            
            // ==================== COSTOS Y GASTOS (500-599) ====================
            ['codigo_agrupador' => '500', 'nivel' => 1, 'nombre_cuenta' => 'COSTOS Y GASTOS', 'tipo' => 'G'],
            ['codigo_agrupador' => '501', 'nivel' => 2, 'nombre_cuenta' => 'Costo de Ventas', 'tipo' => 'G'],
            ['codigo_agrupador' => '501.01', 'nivel' => 3, 'nombre_cuenta' => 'Costo de Materiales', 'tipo' => 'G'],
            ['codigo_agrupador' => '501.02', 'nivel' => 3, 'nombre_cuenta' => 'Costo de Inventarios', 'tipo' => 'G'],
            ['codigo_agrupador' => '502', 'nivel' => 2, 'nombre_cuenta' => 'Costo de Servicios', 'tipo' => 'G'],
            ['codigo_agrupador' => '503', 'nivel' => 2, 'nombre_cuenta' => 'Costo de Obras', 'tipo' => 'G'],
            ['codigo_agrupador' => '510', 'nivel' => 2, 'nombre_cuenta' => 'Gastos de Administración', 'tipo' => 'G'],
            ['codigo_agrupador' => '511', 'nivel' => 3, 'nombre_cuenta' => 'Sueldos y Salarios', 'tipo' => 'G'],
            ['codigo_agrupador' => '511.01', 'nivel' => 4, 'nombre_cuenta' => 'Sueldos Administrativos', 'tipo' => 'G'],
            ['codigo_agrupador' => '511.02', 'nivel' => 4, 'nombre_cuenta' => 'Sueldos Operativos', 'tipo' => 'G'],
            ['codigo_agrupador' => '512', 'nivel' => 3, 'nombre_cuenta' => 'Rentas', 'tipo' => 'G'],
            ['codigo_agrupador' => '513', 'nivel' => 3, 'nombre_cuenta' => 'Servicios Básicos', 'tipo' => 'G'],
            ['codigo_agrupador' => '514', 'nivel' => 3, 'nombre_cuenta' => 'Papelería y Útiles', 'tipo' => 'G'],
            ['codigo_agrupador' => '515', 'nivel' => 3, 'nombre_cuenta' => 'Gastos de Oficina', 'tipo' => 'G'],
            ['codigo_agrupador' => '516', 'nivel' => 3, 'nombre_cuenta' => 'Mantenimiento', 'tipo' => 'G'],
            ['codigo_agrupador' => '517', 'nivel' => 3, 'nombre_cuenta' => 'Gastos de Viaje', 'tipo' => 'G'],
            ['codigo_agrupador' => '518', 'nivel' => 3, 'nombre_cuenta' => 'Honorarios', 'tipo' => 'G'],
            ['codigo_agrupador' => '520', 'nivel' => 2, 'nombre_cuenta' => 'Gastos Financieros', 'tipo' => 'G'],
            ['codigo_agrupador' => '521', 'nivel' => 3, 'nombre_cuenta' => 'Intereses Bancarios', 'tipo' => 'G'],
            ['codigo_agrupador' => '522', 'nivel' => 3, 'nombre_cuenta' => 'Comisiones Bancarias', 'tipo' => 'G'],
            ['codigo_agrupador' => '530', 'nivel' => 2, 'nombre_cuenta' => 'Gastos de Operación', 'tipo' => 'G'],
            ['codigo_agrupador' => '531', 'nivel' => 3, 'nombre_cuenta' => 'Combustibles', 'tipo' => 'G'],
            ['codigo_agrupador' => '532', 'nivel' => 3, 'nombre_cuenta' => 'Viáticos', 'tipo' => 'G'],
            ['codigo_agrupador' => '540', 'nivel' => 2, 'nombre_cuenta' => 'Gastos de Ventas', 'tipo' => 'G'],
            ['codigo_agrupador' => '541', 'nivel' => 3, 'nombre_cuenta' => 'Comisiones', 'tipo' => 'G'],
            ['codigo_agrupador' => '550', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación', 'tipo' => 'G'],
            ['codigo_agrupador' => '551', 'nivel' => 3, 'nombre_cuenta' => 'Depreciación de Equipo', 'tipo' => 'G'],
            ['codigo_agrupador' => '552', 'nivel' => 3, 'nombre_cuenta' => 'Depreciación de Vehículos', 'tipo' => 'G'],
        ];
        
        foreach ($codigosSAT as $codigo) {
            CodigoSat::updateOrCreate(
                ['codigo_agrupador' => $codigo['codigo_agrupador']],
                $codigo
            );
        }
        $this->command->info('   ✓ ' . count($codigosSAT) . ' códigos SAT creados');

        // 2. PROYECTOS
        $this->command->info('2. Creando proyectos...');
        
        $proyectosData = [
            ['codigo' => 'PRO-001', 'nombre' => 'Torre Norte', 'presupuesto' => 5000000],
            ['codigo' => 'PRO-002', 'nombre' => 'Hospital Regional', 'presupuesto' => 8000000],
            ['codigo' => 'PRO-003', 'nombre' => 'Parque Industrial', 'presupuesto' => 12000000],
            ['codigo' => 'PRO-004', 'nombre' => 'Centro Comercial', 'presupuesto' => 15000000],
            ['codigo' => 'PRO-005', 'nombre' => 'Urbanización Las Lomas', 'presupuesto' => 6000000],
        ];
        
        $proyectos = [];
        foreach ($proyectosData as $data) {
            $proyecto = Proyecto::updateOrCreate(
                ['codigo' => $data['codigo']],
                [
                    'nombre' => $data['nombre'],
                    'presupuesto_total' => $data['presupuesto'],
                    'status' => 'activo',
                    'created_by' => 1
                ]
            );
            $proyectos[] = $proyecto;
            $this->command->info("   ✓ Proyecto: {$data['codigo']} - {$data['nombre']}");
        }

        // 3. CUENTA BANCARIA
        $this->command->info('3. Creando cuenta bancaria...');
        $cuentaBancaria = CuentaBancaria::first();
        if (!$cuentaBancaria) {
            $cuentaBancaria = CuentaBancaria::create([
                'banco_id' => 1,
                'numero_cuenta' => '1234567890',
                'clabe' => '012345678901234567',
                'titular' => 'Empresa Prueba',
                'saldo_inicial' => 5000000,
                'saldo_actual' => 5000000,
                'activa' => true,
                'moneda_id' => 1,
                'created_by' => 1
            ]);
        }
        $this->command->info('   ✓ Cuenta bancaria ID: ' . $cuentaBancaria->id);

        // 4. TIPOS
        $tipoEgreso = TipoEgreso::first() ?? TipoEgreso::create(['nombre' => 'General', 'activo' => true]);
        $tipoIngreso = TipoIngreso::first() ?? TipoIngreso::create(['nombre' => 'General', 'activo' => true]);
        $metodoPago = MetodoPago::first() ?? MetodoPago::create(['nombre' => 'Transferencia', 'activo' => true]);
        $moneda = Moneda::where('codigo', 'MXN')->first() ?? Moneda::create(['codigo' => 'MXN', 'nombre' => 'Peso Mexicano', 'simbolo' => '$', 'activa' => true]);

        // 5. DEPÓSITOS (INGRESOS) - Asignados a proyectos
        $this->command->info('4. Creando depósitos (ingresos) por proyecto...');
        
        $ingresosPorProyecto = [
            'PRO-001' => [
                ['monto' => 250000, 'concepto' => 'Anticipo obra', 'codigo_sat' => '403.01', 'mes' => 5, 'dia' => 5],
                ['monto' => 350000, 'concepto' => 'Avance obra', 'codigo_sat' => '403.01', 'mes' => 5, 'dia' => 15],
                ['monto' => 150000, 'concepto' => 'Venta materiales', 'codigo_sat' => '401.01', 'mes' => 5, 'dia' => 20],
            ],
            'PRO-002' => [
                ['monto' => 400000, 'concepto' => 'Anticipo', 'codigo_sat' => '403.01', 'mes' => 5, 'dia' => 3],
                ['monto' => 500000, 'concepto' => 'Avance obra', 'codigo_sat' => '403.01', 'mes' => 5, 'dia' => 18],
                ['monto' => 200000, 'concepto' => 'Servicios técnicos', 'codigo_sat' => '402.02', 'mes' => 5, 'dia' => 25],
            ],
            'PRO-003' => [
                ['monto' => 600000, 'concepto' => 'Anticipo', 'codigo_sat' => '403.02', 'mes' => 5, 'dia' => 2],
                ['monto' => 750000, 'concepto' => 'Avance obra', 'codigo_sat' => '403.02', 'mes' => 5, 'dia' => 22],
            ],
            'PRO-004' => [
                ['monto' => 800000, 'concepto' => 'Anticipo', 'codigo_sat' => '403.02', 'mes' => 5, 'dia' => 8],
                ['monto' => 450000, 'concepto' => 'Venta materiales', 'codigo_sat' => '401.01', 'mes' => 5, 'dia' => 28],
            ],
            'PRO-005' => [
                ['monto' => 300000, 'concepto' => 'Anticipo', 'codigo_sat' => '403.01', 'mes' => 5, 'dia' => 10],
                ['monto' => 250000, 'concepto' => 'Servicios profesionales', 'codigo_sat' => '402.01', 'mes' => 5, 'dia' => 30],
            ],
        ];
        
        $depositosCreados = 0;
        foreach ($ingresosPorProyecto as $codigoProyecto => $ingresos) {
            $proyecto = Proyecto::where('codigo', $codigoProyecto)->first();
            if ($proyecto) {
                foreach ($ingresos as $data) {
                    $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
                    if ($codigoSat) {
                        $fecha = Carbon::create(2026, $data['mes'], $data['dia']);
                        $deposito = Deposito::create([
                            'folio' => Deposito::generarFolio(),
                            'fecha' => $fecha,
                            'monto' => $data['monto'],
                            'concepto' => $data['concepto'] . ' - ' . $proyecto->nombre,
                            'cuenta_bancaria_id' => $cuentaBancaria->id,
                            'proyecto_id' => $proyecto->id,
                            'tipo_ingreso_id' => $tipoIngreso->id,
                            'codigo_sat_id' => $codigoSat->id,
                            'estatus' => 'aplicado',
                            'created_by' => 1,
                            'created_at' => $fecha,
                            'updated_at' => $fecha
                        ]);
                        $this->crearMovimientoBancario($deposito, $cuentaBancaria, 'ingreso', $metodoPago, $proyecto->id);
                        $depositosCreados++;
                    }
                }
            }
        }
        
        // Ingresos adicionales sin proyecto
        $ingresosAdicionales = [
            ['monto' => 50000, 'concepto' => 'Intereses bancarios', 'codigo_sat' => '405', 'mes' => 5, 'dia' => 15],
            ['monto' => 25000, 'concepto' => 'Arrendamiento', 'codigo_sat' => '404', 'mes' => 5, 'dia' => 20],
            ['monto' => 15000, 'concepto' => 'Otros ingresos', 'codigo_sat' => '406', 'mes' => 5, 'dia' => 25],
        ];
        
        foreach ($ingresosAdicionales as $data) {
            $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
            if ($codigoSat) {
                $fecha = Carbon::create(2026, $data['mes'], $data['dia']);
                $deposito = Deposito::create([
                    'folio' => Deposito::generarFolio(),
                    'fecha' => $fecha,
                    'monto' => $data['monto'],
                    'concepto' => $data['concepto'],
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'proyecto_id' => null,
                    'tipo_ingreso_id' => $tipoIngreso->id,
                    'codigo_sat_id' => $codigoSat->id,
                    'estatus' => 'aplicado',
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ]);
                $this->crearMovimientoBancario($deposito, $cuentaBancaria, 'ingreso', $metodoPago, null);
                $depositosCreados++;
            }
        }
        
        $this->command->info("   ✓ Creados {$depositosCreados} depósitos");

        // 6. PAGOS (EGRESOS)
        $this->command->info('5. Creando pagos (egresos) por proyecto...');
        
        $egresosPorProyecto = [
            'PRO-001' => [
                ['monto' => 80000, 'concepto' => 'Materiales construcción', 'codigo_sat' => '501.01', 'mes' => 5, 'dia' => 6],
                ['monto' => 45000, 'concepto' => 'Mano de obra', 'codigo_sat' => '511.02', 'mes' => 5, 'dia' => 10],
                ['monto' => 15000, 'concepto' => 'Renta de maquinaria', 'codigo_sat' => '512', 'mes' => 5, 'dia' => 15],
                ['monto' => 8000, 'concepto' => 'Combustible', 'codigo_sat' => '531', 'mes' => 5, 'dia' => 20],
            ],
            'PRO-002' => [
                ['monto' => 120000, 'concepto' => 'Materiales', 'codigo_sat' => '501.01', 'mes' => 5, 'dia' => 4],
                ['monto' => 60000, 'concepto' => 'Mano de obra', 'codigo_sat' => '511.02', 'mes' => 5, 'dia' => 12],
                ['monto' => 25000, 'concepto' => 'Subcontratos', 'codigo_sat' => '502', 'mes' => 5, 'dia' => 18],
                ['monto' => 10000, 'concepto' => 'Combustible', 'codigo_sat' => '531', 'mes' => 5, 'dia' => 25],
            ],
            'PRO-003' => [
                ['monto' => 200000, 'concepto' => 'Materiales', 'codigo_sat' => '501.01', 'mes' => 5, 'dia' => 3],
                ['monto' => 100000, 'concepto' => 'Mano de obra', 'codigo_sat' => '511.02', 'mes' => 5, 'dia' => 15],
                ['monto' => 30000, 'concepto' => 'Renta maquinaria', 'codigo_sat' => '512', 'mes' => 5, 'dia' => 22],
            ],
            'PRO-004' => [
                ['monto' => 180000, 'concepto' => 'Materiales', 'codigo_sat' => '501.01', 'mes' => 5, 'dia' => 5],
                ['monto' => 90000, 'concepto' => 'Mano de obra', 'codigo_sat' => '511.02', 'mes' => 5, 'dia' => 19],
                ['monto' => 35000, 'concepto' => 'Subcontratos', 'codigo_sat' => '502', 'mes' => 5, 'dia' => 26],
            ],
            'PRO-005' => [
                ['monto' => 70000, 'concepto' => 'Materiales', 'codigo_sat' => '501.01', 'mes' => 5, 'dia' => 8],
                ['monto' => 40000, 'concepto' => 'Mano de obra', 'codigo_sat' => '511.02', 'mes' => 5, 'dia' => 22],
                ['monto' => 12000, 'concepto' => 'Combustible', 'codigo_sat' => '531', 'mes' => 5, 'dia' => 28],
            ],
        ];
        
        // Gastos administrativos (sin proyecto)
        $gastosAdministrativos = [
            ['monto' => 35000, 'concepto' => 'Sueldos administrativos', 'codigo_sat' => '511.01', 'mes' => 5, 'dia' => 5],
            ['monto' => 5000, 'concepto' => 'Luz', 'codigo_sat' => '513', 'mes' => 5, 'dia' => 10],
            ['monto' => 3000, 'concepto' => 'Internet', 'codigo_sat' => '513', 'mes' => 5, 'dia' => 10],
            ['monto' => 4000, 'concepto' => 'Papelería', 'codigo_sat' => '514', 'mes' => 5, 'dia' => 12],
            ['monto' => 15000, 'concepto' => 'Renta oficinas', 'codigo_sat' => '512', 'mes' => 5, 'dia' => 1],
            ['monto' => 2000, 'concepto' => 'Mantenimiento', 'codigo_sat' => '516', 'mes' => 5, 'dia' => 18],
            ['monto' => 800, 'concepto' => 'Comisiones bancarias', 'codigo_sat' => '522', 'mes' => 5, 'dia' => 30],
            ['monto' => 5000, 'concepto' => 'Honorarios', 'codigo_sat' => '518', 'mes' => 5, 'dia' => 25],
            ['monto' => 3000, 'concepto' => 'Viáticos', 'codigo_sat' => '532', 'mes' => 5, 'dia' => 20],
        ];
        
        $pagosCreados = 0;
        
        foreach ($egresosPorProyecto as $codigoProyecto => $egresos) {
            $proyecto = Proyecto::where('codigo', $codigoProyecto)->first();
            if ($proyecto) {
                foreach ($egresos as $data) {
                    $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
                    if ($codigoSat) {
                        $fecha = Carbon::create(2026, $data['mes'], $data['dia']);
                        $pago = Pago::create([
                            'folio' => Pago::generarFolio(),
                            'fecha_pago' => $fecha,
                            'monto' => $data['monto'],
                            'concepto' => $data['concepto'] . ' - ' . $proyecto->nombre,
                            'cuenta_bancaria_id' => $cuentaBancaria->id,
                            'proyecto_id' => $proyecto->id,
                            'tipo_egreso_id' => $tipoEgreso->id,
                            'metodo_pago_id' => $metodoPago->id,
                            'moneda_id' => $moneda->id,
                            'codigo_sat_id' => $codigoSat->id,
                            'estatus' => 'completado',
                            'created_by' => 1,
                            'created_at' => $fecha,
                            'updated_at' => $fecha
                        ]);
                        $this->crearMovimientoBancario($pago, $cuentaBancaria, 'egreso', $metodoPago, $proyecto->id);
                        $pagosCreados++;
                    }
                }
            }
        }
        
        foreach ($gastosAdministrativos as $data) {
            $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
            if ($codigoSat) {
                $fecha = Carbon::create(2026, $data['mes'], $data['dia']);
                $pago = Pago::create([
                    'folio' => Pago::generarFolio(),
                    'fecha_pago' => $fecha,
                    'monto' => $data['monto'],
                    'concepto' => $data['concepto'],
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'proyecto_id' => null,
                    'tipo_egreso_id' => $tipoEgreso->id,
                    'metodo_pago_id' => $metodoPago->id,
                    'moneda_id' => $moneda->id,
                    'codigo_sat_id' => $codigoSat->id,
                    'estatus' => 'completado',
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ]);
                $this->crearMovimientoBancario($pago, $cuentaBancaria, 'egreso', $metodoPago, null);
                $pagosCreados++;
            }
        }
        
        $this->command->info("   ✓ Creados {$pagosCreados} pagos");

        // 7. RESUMEN FINAL
        $this->command->info('=========================================');
        $this->command->info('RESUMEN DE DATOS CREADOS');
        $this->command->info('=========================================');
        
        $totalIngresos = Deposito::sum('monto');
        $totalEgresos = Pago::sum('monto');
        $utilidad = $totalIngresos - $totalEgresos;
        
        $this->command->info("💰 TOTAL INGRESOS: $" . number_format($totalIngresos, 2));
        $this->command->info("💸 TOTAL EGRESOS:  $" . number_format($totalEgresos, 2));
        $this->command->info("📈 UTILIDAD NETA:  $" . number_format($utilidad, 2));
        $this->command->info("📊 MARGEN:        " . ($totalIngresos > 0 ? number_format(($utilidad / $totalIngresos) * 100, 2) : 0) . "%");
        $this->command->info('=========================================');
        $this->command->info('✅ DATOS COMPLETOS CREADOS EXITOSAMENTE');
        $this->command->info('=========================================');
    }
    
    private function crearMovimientoBancario($movimiento, $cuentaBancaria, $tipo, $metodoPago, $proyectoId)
    {
        if ($tipo === 'ingreso') {
            $nuevoSaldo = $cuentaBancaria->saldo_actual + $movimiento->monto;
            $tipoMovimiento = 'ingreso';
            $fecha = $movimiento->fecha;
            $concepto = $movimiento->concepto;
        } else {
            $nuevoSaldo = $cuentaBancaria->saldo_actual - $movimiento->monto;
            $tipoMovimiento = 'egreso';
            $fecha = $movimiento->fecha_pago;
            $concepto = $movimiento->concepto;
        }
        
        $cuentaBancaria->saldo_actual = $nuevoSaldo;
        $cuentaBancaria->save();
        
        MovimientoBancario::create([
            'cuenta_bancaria_id' => $cuentaBancaria->id,
            'proyecto_id' => $proyectoId,
            'tipo' => $tipoMovimiento,
            'metodo_pago_id' => $metodoPago->id,
            'monto' => $movimiento->monto,
            'fecha' => $fecha,
            'concepto' => $concepto,
            'referencia' => $movimiento->folio,
            'status' => 'aplicado',
            'codigo_sat_id' => $movimiento->codigo_sat_id,
            'created_by' => 1,
            'created_at' => $fecha,
            'updated_at' => $fecha
        ]);
    }
}