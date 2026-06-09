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
use App\Models\TipoEgreso;
use App\Models\TipoIngreso;
use App\Models\MetodoPago;
use App\Models\Moneda;
use Carbon\Carbon;

class DatosPruebaEstadoResultadosSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('=========================================');
        $this->command->info('Creando datos de prueba para Estado de Resultados');
        $this->command->info('=========================================');

        // Limpiar datos existentes
        $this->command->info('0. Limpiando datos existentes...');
        DB::table('movimientos_bancarios')->truncate();
        DB::table('pagos')->truncate();
        DB::table('depositos')->truncate();
        
        // Reiniciar secuencias en PostgreSQL
        DB::statement('ALTER SEQUENCE pagos_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE depositos_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE movimientos_bancarios_id_seq RESTART WITH 1');
        $this->command->info('   ✓ Datos limpiados');

        // 1. CÓDIGOS SAT
        $this->command->info('1. Verificando códigos SAT...');
        
        $codigosSAT = [
            ['codigo_agrupador' => '401', 'nivel' => 2, 'nombre_cuenta' => 'Ventas', 'tipo' => 'I'],
            ['codigo_agrupador' => '402', 'nivel' => 2, 'nombre_cuenta' => 'Prestación de Servicios', 'tipo' => 'I'],
            ['codigo_agrupador' => '403', 'nivel' => 2, 'nombre_cuenta' => 'Ingresos por Obras', 'tipo' => 'I'],
            ['codigo_agrupador' => '406', 'nivel' => 2, 'nombre_cuenta' => 'Otros Ingresos', 'tipo' => 'I'],
            ['codigo_agrupador' => '501', 'nivel' => 2, 'nombre_cuenta' => 'Costo de Ventas', 'tipo' => 'G'],
            ['codigo_agrupador' => '512', 'nivel' => 3, 'nombre_cuenta' => 'Rentas', 'tipo' => 'G'],
            ['codigo_agrupador' => '513', 'nivel' => 3, 'nombre_cuenta' => 'Servicios Básicos', 'tipo' => 'G'],
            ['codigo_agrupador' => '514', 'nivel' => 3, 'nombre_cuenta' => 'Papelería y Útiles', 'tipo' => 'G'],
            ['codigo_agrupador' => '515', 'nivel' => 3, 'nombre_cuenta' => 'Gastos de Oficina', 'tipo' => 'G'],
            ['codigo_agrupador' => '516', 'nivel' => 3, 'nombre_cuenta' => 'Mantenimiento', 'tipo' => 'G'],
            ['codigo_agrupador' => '521', 'nivel' => 3, 'nombre_cuenta' => 'Intereses Bancarios', 'tipo' => 'G'],
            ['codigo_agrupador' => '531', 'nivel' => 3, 'nombre_cuenta' => 'Combustibles', 'tipo' => 'G'],
        ];
        
        foreach ($codigosSAT as $codigo) {
            CodigoSat::updateOrCreate(
                ['codigo_agrupador' => $codigo['codigo_agrupador']],
                $codigo
            );
        }
        $this->command->info('   ✓ Códigos SAT verificados/creados');

        // 2. CUENTA BANCARIA
        $this->command->info('2. Creando cuenta bancaria de prueba...');
        $cuentaBancaria = CuentaBancaria::first();
        if (!$cuentaBancaria) {
            $cuentaBancaria = CuentaBancaria::create([
                'banco_id' => 1,
                'numero_cuenta' => '1234567890',
                'clabe' => '012345678901234567',
                'titular' => 'Empresa Prueba',
                'saldo_inicial' => 500000,
                'saldo_actual' => 500000,
                'activa' => true,
                'moneda_id' => 1,
                'created_by' => 1
            ]);
        }
        $this->command->info('   ✓ Cuenta bancaria ID: ' . $cuentaBancaria->id);

        // 3. PROVEEDORES
        $this->command->info('3. Creando proveedores...');
        $proveedoresData = [
            ['nombre' => 'Office Depot', 'rfc' => 'ODE123456789', 'codigo_sat' => '514'],
            ['nombre' => 'CFE', 'rfc' => 'CFE123456789', 'codigo_sat' => '513'],
            ['nombre' => 'Telmex', 'rfc' => 'TEL123456789', 'codigo_sat' => '513'],
            ['nombre' => 'Gasolinera PEMEX', 'rfc' => 'GAS123456789', 'codigo_sat' => '531'],
            ['nombre' => 'Inmobiliaria Plaza', 'rfc' => 'INM123456789', 'codigo_sat' => '512'],
            ['nombre' => 'Mantenimiento Express', 'rfc' => 'MNT123456789', 'codigo_sat' => '516'],
            ['nombre' => 'Materiales Construcción', 'rfc' => 'MAT123456789', 'codigo_sat' => '501'],
            ['nombre' => 'BBVA', 'rfc' => 'BBV123456789', 'codigo_sat' => '521'],
        ];
        
        foreach ($proveedoresData as $data) {
            $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
            Proveedor::updateOrCreate(
                ['rfc' => $data['rfc']],
                ['nombre' => $data['nombre'], 'activo' => true, 'codigo_sat_default_id' => $codigoSat?->id]
            );
            $this->command->info("   ✓ Proveedor: {$data['nombre']} → Código SAT: {$data['codigo_sat']}");
        }

        // 4. CLIENTES
        $this->command->info('4. Creando clientes...');
        $clientesData = [
            ['razon_social' => 'Constructora ABC', 'rfc' => 'CAB123456789', 'codigo_sat' => '401'],
            ['razon_social' => 'Gobierno Municipal', 'rfc' => 'GOM123456789', 'codigo_sat' => '402'],
            ['razon_social' => 'Desarrolladora XYZ', 'rfc' => 'DEX123456789', 'codigo_sat' => '403'],
            ['razon_social' => 'Comercializadora GHI', 'rfc' => 'CGH123456789', 'codigo_sat' => '401'],
            ['razon_social' => 'Servicios Profesionales', 'rfc' => 'SPR123456789', 'codigo_sat' => '402'],
        ];
        
        foreach ($clientesData as $data) {
            $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
            Contacto::updateOrCreate(
                ['rfc' => $data['rfc']],
                [
                    'razon_social' => $data['razon_social'],
                    'nombre_comercial' => $data['razon_social'],
                    'tipo' => 'cliente',
                    'estatus' => true,
                    'codigo_sat_default_id' => $codigoSat?->id,
                    'pais' => 'MEX',
                    'email_facturacion' => 'cliente@example.com',
                    'telefono' => '0000000000',
                    'calle' => 'Calle Principal',
                    'num_exterior' => '123',
                    'colonia' => 'Centro',
                    'codigo_postal' => '00000',
                    'municipio' => 'Municipio',
                    'estado' => 'Estado',
                    'satcat_regimen_fiscal_clave' => '601',
                    'satcat_uso_cfdi_clave' => 'G01',
                    'satcat_formas_pago_clave' => '99',
                    'satcat_metodos_pago_clave' => 'PUE',
                    'dias_credito' => 0,
                    'limite_credito' => 0
                ]
            );
            $this->command->info("   ✓ Cliente: {$data['razon_social']} → Código SAT: {$data['codigo_sat']}");
        }

        // 5. TIPOS Y MÉTODOS
        $this->command->info('5. Verificando tipos de egreso/ingreso...');
        $tipoEgreso = TipoEgreso::first();
        if (!$tipoEgreso) {
            $tipoEgreso = TipoEgreso::create(['nombre' => 'General', 'activo' => true]);
        }
        
        $tipoIngreso = TipoIngreso::first();
        if (!$tipoIngreso) {
            $tipoIngreso = TipoIngreso::create(['nombre' => 'General', 'activo' => true]);
        }
        
        $metodoPago = MetodoPago::first();
        if (!$metodoPago) {
            $metodoPago = MetodoPago::create(['nombre' => 'Transferencia', 'activo' => true]);
        }
        
        $moneda = Moneda::where('codigo', 'MXN')->first();
        if (!$moneda) {
            $moneda = Moneda::create(['codigo' => 'MXN', 'nombre' => 'Peso Mexicano', 'simbolo' => '$', 'activa' => true]);
        }
        
        $this->command->info('   ✓ Metodo Pago ID: ' . $metodoPago->id);

        // 6. PAGOS
        $this->command->info('6. Creando pagos (egresos)...');
        $pagosData = [
            ['proveedor' => 'Office Depot', 'monto' => 3500, 'concepto' => 'Compra de papelería', 'codigo_sat' => '514', 'dias_atras' => 15],
            ['proveedor' => 'Office Depot', 'monto' => 2800, 'concepto' => 'Toner y cartuchos', 'codigo_sat' => '514', 'dias_atras' => 45],
            ['proveedor' => 'Office Depot', 'monto' => 4200, 'concepto' => 'Mobiliario de oficina', 'codigo_sat' => '515', 'dias_atras' => 75],
            ['proveedor' => 'CFE', 'monto' => 1850, 'concepto' => 'Pago de luz', 'codigo_sat' => '513', 'dias_atras' => 10],
            ['proveedor' => 'CFE', 'monto' => 2100, 'concepto' => 'Pago de luz', 'codigo_sat' => '513', 'dias_atras' => 40],
            ['proveedor' => 'CFE', 'monto' => 1950, 'concepto' => 'Pago de luz', 'codigo_sat' => '513', 'dias_atras' => 70],
            ['proveedor' => 'Telmex', 'monto' => 1200, 'concepto' => 'Internet y telefonía', 'codigo_sat' => '513', 'dias_atras' => 20],
            ['proveedor' => 'Telmex', 'monto' => 1200, 'concepto' => 'Internet y telefonía', 'codigo_sat' => '513', 'dias_atras' => 50],
            ['proveedor' => 'Telmex', 'monto' => 1200, 'concepto' => 'Internet y telefonía', 'codigo_sat' => '513', 'dias_atras' => 80],
            ['proveedor' => 'Gasolinera PEMEX', 'monto' => 3200, 'concepto' => 'Combustible flotilla', 'codigo_sat' => '531', 'dias_atras' => 5],
            ['proveedor' => 'Gasolinera PEMEX', 'monto' => 4500, 'concepto' => 'Combustible flotilla', 'codigo_sat' => '531', 'dias_atras' => 35],
            ['proveedor' => 'Gasolinera PEMEX', 'monto' => 3800, 'concepto' => 'Combustible flotilla', 'codigo_sat' => '531', 'dias_atras' => 65],
            ['proveedor' => 'Inmobiliaria Plaza', 'monto' => 15000, 'concepto' => 'Renta de oficinas', 'codigo_sat' => '512', 'dias_atras' => 5],
            ['proveedor' => 'Inmobiliaria Plaza', 'monto' => 15000, 'concepto' => 'Renta de oficinas', 'codigo_sat' => '512', 'dias_atras' => 35],
            ['proveedor' => 'Inmobiliaria Plaza', 'monto' => 15000, 'concepto' => 'Renta de oficinas', 'codigo_sat' => '512', 'dias_atras' => 65],
            ['proveedor' => 'Mantenimiento Express', 'monto' => 2500, 'concepto' => 'Mantenimiento preventivo', 'codigo_sat' => '516', 'dias_atras' => 25],
            ['proveedor' => 'Mantenimiento Express', 'monto' => 1800, 'concepto' => 'Reparación menor', 'codigo_sat' => '516', 'dias_atras' => 55],
            ['proveedor' => 'Materiales Construcción', 'monto' => 25000, 'concepto' => 'Material para obra', 'codigo_sat' => '501', 'dias_atras' => 10],
            ['proveedor' => 'Materiales Construcción', 'monto' => 32000, 'concepto' => 'Material para obra', 'codigo_sat' => '501', 'dias_atras' => 40],
            ['proveedor' => 'Materiales Construcción', 'monto' => 28000, 'concepto' => 'Material para obra', 'codigo_sat' => '501', 'dias_atras' => 70],
            ['proveedor' => 'BBVA', 'monto' => 850, 'concepto' => 'Intereses crédito', 'codigo_sat' => '521', 'dias_atras' => 30],
            ['proveedor' => 'BBVA', 'monto' => 920, 'concepto' => 'Intereses crédito', 'codigo_sat' => '521', 'dias_atras' => 60],
        ];
        
        $pagosCreados = 0;
        foreach ($pagosData as $data) {
            $proveedor = Proveedor::where('nombre', $data['proveedor'])->first();
            $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
            if ($proveedor && $codigoSat) {
                $fecha = Carbon::now()->subDays($data['dias_atras']);
                
                // Generar folio único
                $folio = 'PAG-' . $fecha->format('Ymd') . '-' . str_pad($pagosCreados + 1, 4, '0', STR_PAD_LEFT);
                
                $pago = Pago::create([
                    'folio' => $folio,
                    'fecha_pago' => $fecha,
                    'monto' => $data['monto'],
                    'concepto' => $data['concepto'],
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'proveedor_id' => $proveedor->id,
                    'proveedor_nombre' => $proveedor->nombre,
                    'proveedor_rfc' => $proveedor->rfc,
                    'tipo_egreso_id' => $tipoEgreso->id,
                    'metodo_pago_id' => $metodoPago->id,
                    'moneda_id' => $moneda->id,
                    'codigo_sat_id' => $codigoSat->id,
                    'estatus' => 'completado',
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ]);
                $this->crearMovimientoBancario($pago, $cuentaBancaria, 'egreso', $metodoPago, $tipoEgreso, $tipoIngreso);
                $pagosCreados++;
            }
        }
        $this->command->info("   ✓ Creados {$pagosCreados} pagos");

        // 7. DEPÓSITOS
        $this->command->info('7. Creando depósitos (ingresos)...');
        $depositosData = [
            ['cliente' => 'Constructora ABC', 'monto' => 45000, 'concepto' => 'Venta de materiales', 'codigo_sat' => '401', 'dias_atras' => 5],
            ['cliente' => 'Constructora ABC', 'monto' => 38000, 'concepto' => 'Venta de materiales', 'codigo_sat' => '401', 'dias_atras' => 35],
            ['cliente' => 'Constructora ABC', 'monto' => 52000, 'concepto' => 'Venta de materiales', 'codigo_sat' => '401', 'dias_atras' => 65],
            ['cliente' => 'Comercializadora GHI', 'monto' => 28000, 'concepto' => 'Venta de productos', 'codigo_sat' => '401', 'dias_atras' => 15],
            ['cliente' => 'Comercializadora GHI', 'monto' => 32000, 'concepto' => 'Venta de productos', 'codigo_sat' => '401', 'dias_atras' => 45],
            ['cliente' => 'Comercializadora GHI', 'monto' => 35000, 'concepto' => 'Venta de productos', 'codigo_sat' => '401', 'dias_atras' => 75],
            ['cliente' => 'Gobierno Municipal', 'monto' => 35000, 'concepto' => 'Servicio de consultoría', 'codigo_sat' => '402', 'dias_atras' => 10],
            ['cliente' => 'Gobierno Municipal', 'monto' => 42000, 'concepto' => 'Servicio de consultoría', 'codigo_sat' => '402', 'dias_atras' => 40],
            ['cliente' => 'Servicios Profesionales', 'monto' => 18000, 'concepto' => 'Servicios administrativos', 'codigo_sat' => '402', 'dias_atras' => 20],
            ['cliente' => 'Servicios Profesionales', 'monto' => 22000, 'concepto' => 'Servicios administrativos', 'codigo_sat' => '402', 'dias_atras' => 50],
            ['cliente' => 'Desarrolladora XYZ', 'monto' => 85000, 'concepto' => 'Anticipo obra', 'codigo_sat' => '403', 'dias_atras' => 8],
            ['cliente' => 'Desarrolladora XYZ', 'monto' => 95000, 'concepto' => 'Avance de obra', 'codigo_sat' => '403', 'dias_atras' => 38],
            ['cliente' => 'Desarrolladora XYZ', 'monto' => 120000, 'concepto' => 'Liquidación obra', 'codigo_sat' => '403', 'dias_atras' => 68],
            ['cliente' => null, 'monto' => 5000, 'concepto' => 'Intereses bancarios', 'codigo_sat' => '406', 'dias_atras' => 30],
            ['cliente' => null, 'monto' => 3200, 'concepto' => 'Venta de activo fijo', 'codigo_sat' => '406', 'dias_atras' => 60],
        ];
        
        $depositosCreados = 0;
        foreach ($depositosData as $data) {
            $codigoSat = CodigoSat::where('codigo_agrupador', $data['codigo_sat'])->first();
            if ($codigoSat) {
                $fecha = Carbon::now()->subDays($data['dias_atras']);
                
                // Generar folio único
                $folio = 'DEP-' . $fecha->format('Ymd') . '-' . str_pad($depositosCreados + 1, 4, '0', STR_PAD_LEFT);
                
                $deposito = Deposito::create([
                    'folio' => $folio,
                    'fecha' => $fecha,
                    'monto' => $data['monto'],
                    'concepto' => $data['concepto'],
                    'cuenta_bancaria_id' => $cuentaBancaria->id,
                    'tipo_ingreso_id' => $tipoIngreso->id,
                    'codigo_sat_id' => $codigoSat->id,
                    'estatus' => 'aplicado',
                    'created_by' => 1,
                    'created_at' => $fecha,
                    'updated_at' => $fecha
                ]);
                $this->crearMovimientoBancario($deposito, $cuentaBancaria, 'ingreso', $metodoPago, $tipoEgreso, $tipoIngreso);
                $depositosCreados++;
            }
        }
        $this->command->info("   ✓ Creados {$depositosCreados} depósitos");

        // 8. RESUMEN
        $this->command->info('=========================================');
        $this->command->info('RESUMEN DE DATOS CREADOS');
        $this->command->info('=========================================');
        $totalIngresos = Deposito::sum('monto');
        $totalEgresos = Pago::sum('monto');
        $utilidad = $totalIngresos - $totalEgresos;
        $this->command->info("💰 TOTAL INGRESOS: $" . number_format($totalIngresos, 2));
        $this->command->info("💸 TOTAL EGRESOS:  $" . number_format($totalEgresos, 2));
        $this->command->info("📈 UTILIDAD NETA:  $" . number_format($utilidad, 2));
        $this->command->info('=========================================');
        $this->command->info('✅ DATOS DE PRUEBA CREADOS EXITOSAMENTE');
        $this->command->info('=========================================');
    }
    
    private function crearMovimientoBancario($movimiento, $cuentaBancaria, $tipo, $metodoPago, $tipoEgreso, $tipoIngreso)
    {
        $saldoAnterior = $cuentaBancaria->saldo_actual;
        
        if ($tipo === 'ingreso') {
            $nuevoSaldo = $saldoAnterior + $movimiento->monto;
            $tipoMovimiento = 'ingreso';
            $fecha = $movimiento->fecha;
            $concepto = $movimiento->concepto;
            $tipoIngresoId = $tipoIngreso->id;
            $tipoEgresoId = null;
        } else {
            $nuevoSaldo = $saldoAnterior - $movimiento->monto;
            $tipoMovimiento = 'egreso';
            $fecha = $movimiento->fecha_pago;
            $concepto = $movimiento->concepto;
            $tipoIngresoId = null;
            $tipoEgresoId = $tipoEgreso->id;
        }
        
        // Actualizar saldo de la cuenta
        $cuentaBancaria->saldo_actual = $nuevoSaldo;
        $cuentaBancaria->save();
        
        // Crear movimiento bancario
        MovimientoBancario::create([
            'cuenta_bancaria_id' => $cuentaBancaria->id,
            'tipo' => $tipoMovimiento,
            'tipo_ingreso_id' => $tipoIngresoId,
            'tipo_egreso_id' => $tipoEgresoId,
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
