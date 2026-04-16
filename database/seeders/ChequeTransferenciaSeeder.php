<?php
// database/seeders/ChequeTransferenciaSeeder.php
namespace Database\Seeders;

use App\Models\ChequeTransferencia;
use App\Models\CuentaBancaria;
use App\Models\Moneda;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChequeTransferenciaSeeder extends Seeder
{
    public function run()
    {
        // Obtener IDs de referencia
        $cuentaBancaria = CuentaBancaria::first();
        $monedaMxn = Moneda::where('codigo', 'MXN')->first();
        $monedaUsd = Moneda::where('codigo', 'USD')->first();
        $user = User::first();
        
        if (!$cuentaBancaria || !$monedaMxn || !$user) {
            $this->command->info('Faltan datos de referencia. Ejecuta primero los seeders de cuentas bancarias, monedas y usuarios.');
            return;
        }
        
        $chequesTransferencias = [
            [
                'folio' => 'CT-202601-0001',
                'estatus' => 'activo',
                'forma_pago' => 'transferencia',
                'proveedor' => 'Transportes del Bajío',
                'rfc' => 'TRA850101ABC',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-001',
                'referencia_bancaria' => 'BAN-001',
                'fecha' => '2026-01-15',
                'fecha_vencimiento' => '2026-02-15',
                'monto' => 50000.00,
                'monto_restante' => 0.00,
                'moneda_id' => $monedaMxn->id,
                'tipo_cambio' => 1.00,
                'monto_original' => 50000.00,
                'descripcion' => 'Pago de servicios de transporte',
                'poliza_contable' => 'POL-001',
                'observaciones' => 'Pago realizado en tiempo',
                'created_by' => $user->id
            ],
            [
                'folio' => 'CT-202601-0002',
                'estatus' => 'activo',
                'forma_pago' => 'cheque',
                'proveedor' => 'Logística Monterrey',
                'rfc' => 'LOG850202DEF',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-002',
                'referencia_bancaria' => 'CHE-002',
                'fecha' => '2026-01-14',
                'fecha_vencimiento' => '2026-02-14',
                'monto' => 75000.00,
                'monto_restante' => 15000.00,
                'moneda_id' => $monedaMxn->id,
                'tipo_cambio' => 1.00,
                'monto_original' => 75000.00,
                'descripcion' => 'Pago de facturas',
                'poliza_contable' => 'POL-002',
                'observaciones' => 'Pago parcial',
                'created_by' => $user->id
            ],
            [
                'folio' => 'CT-202601-0003',
                'estatus' => 'activo',
                'forma_pago' => 'transferencia',
                'proveedor' => 'Autotransportes Mexicanos',
                'rfc' => 'AUT850303GHI',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-003',
                'referencia_bancaria' => 'BAN-003',
                'fecha' => '2026-01-13',
                'fecha_vencimiento' => '2026-02-13',
                'monto' => 32000.00,
                'monto_restante' => 0.00,
                'moneda_id' => $monedaMxn->id,
                'tipo_cambio' => 1.00,
                'monto_original' => 32000.00,
                'descripcion' => 'Pago de servicios',
                'poliza_contable' => 'POL-003',
                'observaciones' => null,
                'created_by' => $user->id
            ],
            [
                'folio' => 'CT-202601-0004',
                'estatus' => 'activo',
                'forma_pago' => 'cheque',
                'proveedor' => 'Ferrocarriles Nacionales',
                'rfc' => 'FER850404JKL',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-004',
                'referencia_bancaria' => 'CHE-004',
                'fecha' => '2026-01-12',
                'fecha_vencimiento' => '2026-02-12',
                'monto' => 68000.00,
                'monto_restante' => 8000.00,
                'moneda_id' => $monedaMxn->id,
                'tipo_cambio' => 1.00,
                'monto_original' => 68000.00,
                'descripcion' => 'Pago de fletes',
                'poliza_contable' => 'POL-004',
                'observaciones' => 'Pendiente de completar',
                'created_by' => $user->id
            ],
            [
                'folio' => 'CT-202601-0005',
                'estatus' => 'activo',
                'forma_pago' => 'transferencia',
                'proveedor' => 'Cervecería del Centro',
                'rfc' => 'CER850505MNO',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-005',
                'referencia_bancaria' => 'BAN-005',
                'fecha' => '2026-01-11',
                'fecha_vencimiento' => '2026-02-11',
                'monto' => 45000.00,
                'monto_restante' => 0.00,
                'moneda_id' => $monedaMxn->id,
                'tipo_cambio' => 1.00,
                'monto_original' => 45000.00,
                'descripcion' => 'Pago de servicios',
                'poliza_contable' => 'POL-005',
                'observaciones' => null,
                'created_by' => $user->id
            ],
            [
                'folio' => 'CT-202601-0006',
                'estatus' => 'activo',
                'forma_pago' => 'cheque',
                'proveedor' => 'Papelera del Pacífico',
                'rfc' => 'PAP850606PQR',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-006',
                'referencia_bancaria' => 'CHE-006',
                'fecha' => '2026-01-10',
                'fecha_vencimiento' => '2026-02-10',
                'monto' => 89000.00,
                'monto_restante' => 12000.00,
                'moneda_id' => $monedaMxn->id,
                'tipo_cambio' => 1.00,
                'monto_original' => 89000.00,
                'descripcion' => 'Pago de materiales',
                'poliza_contable' => 'POL-006',
                'observaciones' => 'Pago pendiente de confirmación',
                'created_by' => $user->id
            ],
            [
                'folio' => 'CT-202601-0007',
                'estatus' => 'activo',
                'forma_pago' => 'transferencia',
                'proveedor' => 'Minería del Norte',
                'rfc' => 'MIN850707STU',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-007',
                'referencia_bancaria' => 'BAN-007',
                'fecha' => '2026-01-09',
                'fecha_vencimiento' => '2026-02-09',
                'monto' => 120000.00,
                'monto_restante' => 20000.00,
                'moneda_id' => $monedaUsd->id,
                'tipo_cambio' => 20.50,
                'monto_original' => 5853.66,
                'descripcion' => 'Pago en USD',
                'poliza_contable' => 'POL-007',
                'observaciones' => 'Pago en moneda extranjera',
                'created_by' => $user->id
            ],
            [
                'folio' => 'CT-202601-0008',
                'estatus' => 'cancelado',
                'forma_pago' => 'cheque',
                'proveedor' => 'Comercializadora del Sur',
                'rfc' => 'COM850808VWX',
                'cuenta_bancaria_id' => $cuentaBancaria->id,
                'referencia' => 'REF-008',
                'referencia_bancaria' => 'CHE-008',
                'fecha' => '2026-01-08',
                'fecha_vencimiento' => '2026-02-08',
                'monto' => 25000.00,
                'monto_restante' => 25000.00,
                'moneda_id' => $monedaMxn->id,
                'tipo_cambio' => 1.00,
                'monto_original' => 25000.00,
                'descripcion' => 'Pago cancelado',
                'poliza_contable' => null,
                'observaciones' => 'Pago cancelado por el cliente',
                'created_by' => $user->id
            ]
        ];
        
        foreach ($chequesTransferencias as $data) {
            ChequeTransferencia::create($data);
        }
        
        $this->command->info('Seeder de Cheques y Transferencias ejecutado correctamente. Se crearon ' . count($chequesTransferencias) . ' registros.');
    }
}