<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CodigoSat;
use App\Models\Proyecto;
use App\Models\CuentaBancaria;
use App\Models\TipoEgreso;
use App\Models\TipoIngreso;
use App\Models\MetodoPago;
use App\Models\Moneda;
use Carbon\Carbon;

class DatosMasivosEstadoResultadosSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('=========================================');
        $this->command->info('CREANDO DATOS MASIVOS PARA ESTADO DE RESULTADOS');
        $this->command->info('=========================================');

        // 1. Obtener o crear códigos SAT necesarios
        $this->command->info('1. Verificando códigos SAT...');
        
        $codigosSAT = [
            // INGRESOS
            ['codigo_agrupador' => '400', 'nivel' => 1, 'nombre_cuenta' => 'INGRESOS NETOS', 'tipo' => 'I'],
            ['codigo_agrupador' => '401', 'nivel' => 2, 'nombre_cuenta' => 'Ventas', 'tipo' => 'I'],
            ['codigo_agrupador' => '401.01', 'nivel' => 3, 'nombre_cuenta' => 'Ventas Nacionales', 'tipo' => 'I'],
            ['codigo_agrupador' => '402', 'nivel' => 2, 'nombre_cuenta' => 'Prestación de Servicios', 'tipo' => 'I'],
            ['codigo_agrupador' => '402.01', 'nivel' => 3, 'nombre_cuenta' => 'Servicios Profesionales', 'tipo' => 'I'],
            ['codigo_agrupador' => '403', 'nivel' => 2, 'nombre_cuenta' => 'Ingresos por Obras', 'tipo' => 'I'],
            ['codigo_agrupador' => '403.01', 'nivel' => 3, 'nombre_cuenta' => 'Obras Públicas', 'tipo' => 'I'],
            ['codigo_agrupador' => '403.02', 'nivel' => 3, 'nombre_cuenta' => 'Obras Privadas', 'tipo' => 'I'],
            ['codigo_agrupador' => '404', 'nivel' => 2, 'nombre_cuenta' => 'Arrendamiento', 'tipo' => 'I'],
            ['codigo_agrupador' => '405', 'nivel' => 2, 'nombre_cuenta' => 'Intereses a Favor', 'tipo' => 'I'],
            ['codigo_agrupador' => '406', 'nivel' => 2, 'nombre_cuenta' => 'Otros Ingresos', 'tipo' => 'I'],
            
            // GASTOS
            ['codigo_agrupador' => '500', 'nivel' => 1, 'nombre_cuenta' => 'COSTOS Y GASTOS', 'tipo' => 'G'],
            ['codigo_agrupador' => '501', 'nivel' => 2, 'nombre_cuenta' => 'Costo de Ventas', 'tipo' => 'G'],
            ['codigo_agrupador' => '501.01', 'nivel' => 3, 'nombre_cuenta' => 'Materiales Directos', 'tipo' => 'G'],
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
        ];
        
        foreach ($codigosSAT as $codigo) {
            CodigoSat::updateOrCreate(
                ['codigo_agrupador' => $codigo['codigo_agrupador']],
                $codigo
            );
        }
        $this->command->info('   ✓ ' . count($codigosSAT) . ' códigos SAT');

        // 2. Obtener proyectos
        $proyectos = Proyecto::where('status', 'activo')->get();
        if ($proyectos->isEmpty()) {
            $this->command->error('No hay proyectos activos. Cree proyectos primero.');
            return;
        }
        $this->command->info('2. Proyectos encontrados: ' . $proyectos->count());

        // 3. Cuenta bancaria
        $cuentaBancaria = CuentaBancaria::first();
        if (!$cuentaBancaria) {
            $cuentaBancaria = CuentaBancaria::create([
                'banco_id' => 1,
                'numero_cuenta' => '1234567890',
                'clabe' => '012345678901234567',
                'titular' => 'Empresa Prueba',
                'saldo_inicial' => 50000000,
                'saldo_actual' => 50000000,
                'activa' => true,
                'moneda_id' => 1,
                'created_by' => 1
            ]);
        }
        
        // 4. Tipos
        $tipoEgreso = TipoEgreso::first() ?? TipoEgreso::create(['nombre' => 'General', 'activo' => true]);
        $tipoIngreso = TipoIngreso::first() ?? TipoIngreso::create(['nombre' => 'General', 'activo' => true]);
        $metodoPago = MetodoPago::first() ?? MetodoPago::create(['nombre' => 'Transferencia', 'activo' => true]);
        $moneda = Moneda::where('codigo', 'MXN')->first() ?? Moneda::create(['codigo' => 'MXN', 'nombre' => 'Peso Mexicano', 'simbolo' => '$', 'activa' => true]);

        // Limpiar datos existentes
        $this->command->info('3. Limpiando datos existentes...');
        DB::table('movimientos_bancarios')->truncate();
        DB::table('pagos')->truncate();
        DB::table('depositos')->truncate();
        
        // 5. Generar DEPÓSITOS (INGRESOS) masivos
        $this->command->info('4. Generando depósitos masivos...');
        
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $anios = [2024, 2025, 2026];
        
        $codigosIngresos = [
            '401.01' => 'Venta de materiales',
            '402.01' => 'Servicios profesionales',
            '403.01' => 'Anticipo obra pública',
            '403.02' => 'Anticipo obra privada',
            '404' => 'Renta de equipo',
            '405' => 'Intereses bancarios',
            '406' => 'Otros ingresos'
        ];
        
        $depositosCreados = 0;
        $movimientosIngreso = [];
        
        foreach ($proyectos as $proyecto) {
            foreach ($anios as $anio) {
                foreach ($meses as $mesIndex => $mes) {
                    $numIngresos = rand(2, 5);
                    for ($i = 0; $i < $numIngresos; $i++) {
                        $codigo = array_rand($codigosIngresos);
                        $codigoSat = CodigoSat::where('codigo_agrupador', $codigo)->first();
                        if ($codigoSat) {
                            $dia = rand(1, 28);
                            $fecha = Carbon::create($anio, $mesIndex + 1, $dia);
                            
                            if (strpos($codigo, '401') !== false) {
                                $monto = rand(50000, 300000);
                            } elseif (strpos($codigo, '402') !== false) {
                                $monto = rand(20000, 150000);
                            } elseif (strpos($codigo, '403') !== false) {
                                $monto = rand(100000, 800000);
                            } else {
                                $monto = rand(5000, 50000);
                            }
                            
                            $folio = 'DEP-' . $anio . str_pad($mesIndex + 1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($depositosCreados + 1, 4, '0', STR_PAD_LEFT);
                            $concepto = $codigosIngresos[$codigo] . ' - ' . $proyecto->nombre . ' (' . $mes . ' ' . $anio . ')';
                            
                            DB::table('depositos')->insert([
                                'folio' => $folio,
                                'fecha' => $fecha,
                                'monto' => $monto,
                                'concepto' => $concepto,
                                'cuenta_bancaria_id' => $cuentaBancaria->id,
                                'proyecto_id' => $proyecto->id,
                                'tipo_ingreso_id' => $tipoIngreso->id,
                                'codigo_sat_id' => $codigoSat->id,
                                'estatus' => 'aplicado',
                                'created_by' => 1,
                                'created_at' => $fecha,
                                'updated_at' => $fecha
                            ]);
                            
                            $movimientosIngreso[] = [
                                'cuenta_bancaria_id' => $cuentaBancaria->id,
                                'proyecto_id' => $proyecto->id,
                                'tipo' => 'ingreso',
                                'metodo_pago_id' => $metodoPago->id,
                                'monto' => $monto,
                                'fecha' => $fecha,
                                'concepto' => $concepto,
                                'referencia' => $folio,
                                'status' => 'aplicado',
                                'codigo_sat_id' => $codigoSat->id,
                                'created_by' => 1,
                                'created_at' => $fecha,
                                'updated_at' => $fecha
                            ];
                            $depositosCreados++;
                        }
                    }
                }
            }
        }
        
        // Ingresos adicionales sin proyecto
        for ($i = 0; $i < 50; $i++) {
            $codigo = '406';
            $codigoSat = CodigoSat::where('codigo_agrupador', $codigo)->first();
            if ($codigoSat) {
                $anio = $anios[array_rand($anios)];
                $mes = rand(1, 12);
                $dia = rand(1, 28);
                $fecha = Carbon::create($anio, $mes, $dia);
                $monto = rand(1000, 15000);
                $folio = 'DEP-ADIC-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT);
                $concepto = 'Ingreso adicional - ' . $codigosIngresos[$codigo];
                
                DB::table('depositos')->insert([
                    'folio' => $folio,
                    'fecha' => $fecha,
                    'monto' => $monto,
                    'concepto' => $concepto,
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'proyecto_id' => null,
                    'tipo_ingreso_id' => $tipoIngreso->id,
                    'codigo_sat_id' => $codigoSat->id,
                    'estatus' => 'aplicado',
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ]);
                
                $movimientosIngreso[] = [
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'proyecto_id' => null,
                    'tipo' => 'ingreso',
                    'metodo_pago_id' => $metodoPago->id,
                    'monto' => $monto,
                    'fecha' => $fecha,
                    'concepto' => $concepto,
                    'referencia' => $folio,
                    'status' => 'aplicado',
                    'codigo_sat_id' => $codigoSat->id,
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ];
                $depositosCreados++;
            }
        }
        
        $this->command->info("   ✓ Creados {$depositosCreados} depósitos");

        // 6. Generar PAGOS (EGRESOS) masivos
        $this->command->info('5. Generando pagos masivos...');
        
        $codigosGastos = [
            '501.01' => ['nombre' => 'Materiales de construcción', 'min' => 10000, 'max' => 200000],
            '511.01' => ['nombre' => 'Sueldos administrativos', 'min' => 30000, 'max' => 100000],
            '511.02' => ['nombre' => 'Sueldos operativos', 'min' => 25000, 'max' => 80000],
            '512' => ['nombre' => 'Renta de oficinas/bodegas', 'min' => 10000, 'max' => 50000],
            '513' => ['nombre' => 'Servicios (luz, agua, internet)', 'min' => 2000, 'max' => 15000],
            '514' => ['nombre' => 'Papelería y útiles', 'min' => 1000, 'max' => 8000],
            '515' => ['nombre' => 'Gastos de oficina', 'min' => 500, 'max' => 5000],
            '516' => ['nombre' => 'Mantenimiento', 'min' => 3000, 'max' => 25000],
            '517' => ['nombre' => 'Gastos de viaje', 'min' => 2000, 'max' => 20000],
            '518' => ['nombre' => 'Honorarios', 'min' => 5000, 'max' => 40000],
            '521' => ['nombre' => 'Intereses bancarios', 'min' => 500, 'max' => 8000],
            '522' => ['nombre' => 'Comisiones bancarias', 'min' => 100, 'max' => 3000],
            '531' => ['nombre' => 'Combustible', 'min' => 2000, 'max' => 20000],
            '532' => ['nombre' => 'Viáticos', 'min' => 1000, 'max' => 15000],
            '541' => ['nombre' => 'Comisiones', 'min' => 5000, 'max' => 30000],
        ];
        
        $pagosCreados = 0;
        $movimientosEgreso = [];
        
        foreach ($proyectos as $proyecto) {
            foreach ($anios as $anio) {
                foreach ($meses as $mesIndex => $mes) {
                    $numGastos = rand(5, 15);
                    for ($i = 0; $i < $numGastos; $i++) {
                        $codigo = array_rand($codigosGastos);
                        $gastoInfo = $codigosGastos[$codigo];
                        $codigoSat = CodigoSat::where('codigo_agrupador', $codigo)->first();
                        if ($codigoSat) {
                            $dia = rand(1, 28);
                            $fecha = Carbon::create($anio, $mesIndex + 1, $dia);
                            $monto = rand($gastoInfo['min'], $gastoInfo['max']);
                            $folio = 'PAG-' . $anio . str_pad($mesIndex + 1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($pagosCreados + 1, 4, '0', STR_PAD_LEFT);
                            $concepto = $gastoInfo['nombre'] . ' - ' . $proyecto->nombre . ' (' . $mes . ' ' . $anio . ')';
                            
                            DB::table('pagos')->insert([
                                'folio' => $folio,
                                'fecha_pago' => $fecha,
                                'monto' => $monto,
                                'concepto' => $concepto,
                                'cuenta_bancaria_id' => $cuentaBancaria->id,
                                'proyecto_id' => $proyecto->id,
                                'proveedor_nombre' => 'Proveedor ' . rand(1, 20),
                                'proveedor_rfc' => 'RFC' . rand(100000, 999999),
                                'tipo_egreso_id' => $tipoEgreso->id,
                                'metodo_pago_id' => $metodoPago->id,
                                'moneda_id' => $moneda->id,
                                'codigo_sat_id' => $codigoSat->id,
                                'estatus' => 'completado',
                                'created_by' => 1,
                                'created_at' => $fecha,
                                'updated_at' => $fecha
                            ]);
                            
                            $movimientosEgreso[] = [
                                'cuenta_bancaria_id' => $cuentaBancaria->id,
                                'proyecto_id' => $proyecto->id,
                                'tipo' => 'egreso',
                                'metodo_pago_id' => $metodoPago->id,
                                'monto' => $monto,
                                'fecha' => $fecha,
                                'concepto' => $concepto,
                                'referencia' => $folio,
                                'status' => 'aplicado',
                                'codigo_sat_id' => $codigoSat->id,
                                'created_by' => 1,
                                'created_at' => $fecha,
                                'updated_at' => $fecha
                            ];
                            $pagosCreados++;
                        }
                    }
                }
            }
        }
        
        // Gastos administrativos sin proyecto
        for ($i = 0; $i < 100; $i++) {
            $codigo = array_rand($codigosGastos);
            $gastoInfo = $codigosGastos[$codigo];
            $codigoSat = CodigoSat::where('codigo_agrupador', $codigo)->first();
            if ($codigoSat) {
                $anio = $anios[array_rand($anios)];
                $mes = rand(1, 12);
                $dia = rand(1, 28);
                $fecha = Carbon::create($anio, $mes, $dia);
                $monto = rand($gastoInfo['min'], $gastoInfo['max']);
                $folio = 'PAG-ADMIN-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT);
                $concepto = $gastoInfo['nombre'] . ' - Gastos administrativos';
                
                DB::table('pagos')->insert([
                    'folio' => $folio,
                    'fecha_pago' => $fecha,
                    'monto' => $monto,
                    'concepto' => $concepto,
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'proyecto_id' => null,
                    'proveedor_nombre' => 'Proveedor Admin ' . rand(1, 10),
                    'proveedor_rfc' => 'RFCADM' . rand(10000, 99999),
                    'tipo_egreso_id' => $tipoEgreso->id,
                    'metodo_pago_id' => $metodoPago->id,
                    'moneda_id' => $moneda->id,
                    'codigo_sat_id' => $codigoSat->id,
                    'estatus' => 'completado',
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ]);
                
                $movimientosEgreso[] = [
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'proyecto_id' => null,
                    'tipo' => 'egreso',
                    'metodo_pago_id' => $metodoPago->id,
                    'monto' => $monto,
                    'fecha' => $fecha,
                    'concepto' => $concepto,
                    'referencia' => $folio,
                    'status' => 'aplicado',
                    'codigo_sat_id' => $codigoSat->id,
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ];
                $pagosCreados++;
            }
        }
        
        $this->command->info("   ✓ Creados {$pagosCreados} pagos");

        // 7. Insertar movimientos bancarios en lote
        $this->command->info('6. Creando movimientos bancarios...');
        
        $todosMovimientos = array_merge($movimientosIngreso, $movimientosEgreso);
        
        // Insertar en lotes de 500
        $lotes = array_chunk($todosMovimientos, 500);
        foreach ($lotes as $lote) {
            DB::table('movimientos_bancarios')->insert($lote);
        }
        
        $this->command->info("   ✓ Creados " . count($todosMovimientos) . " movimientos bancarios");

        // 8. Actualizar saldo de cuenta bancaria
        $totalIngresos = DB::table('depositos')->sum('monto');
        $totalEgresos = DB::table('pagos')->sum('monto');
        $saldoFinal = 50000000 + $totalIngresos - $totalEgresos;
        
        DB::table('cuentas_bancarias')->where('id', $cuentaBancaria->id)->update(['saldo_actual' => $saldoFinal]);

        // 9. RESUMEN FINAL
        $this->command->info('=========================================');
        $this->command->info('RESUMEN DE DATOS CREADOS');
        $this->command->info('=========================================');
        
        $utilidad = $totalIngresos - $totalEgresos;
        
        $this->command->info("💰 TOTAL INGRESOS: $" . number_format($totalIngresos, 2));
        $this->command->info("💸 TOTAL EGRESOS:  $" . number_format($totalEgresos, 2));
        $this->command->info("📈 UTILIDAD NETA:  $" . number_format($utilidad, 2));
        $this->command->info("📊 MARGEN:        " . ($totalIngresos > 0 ? number_format(($utilidad / $totalIngresos) * 100, 2) : 0) . "%");
        $this->command->info("🏦 SALDO FINAL:   $" . number_format($saldoFinal, 2));
        $this->command->info('=========================================');
        $this->command->info('✅ DATOS MASIVOS CREADOS EXITOSAMENTE');
        $this->command->info('=========================================');
    }
}