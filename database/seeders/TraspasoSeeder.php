<?php
// database/seeders/TraspasoSeeder.php
namespace Database\Seeders;

use App\Models\Traspaso;
use App\Models\CuentaBancaria;
use App\Models\Moneda;
use App\Models\User;
use Illuminate\Database\Seeder;

class TraspasoSeeder extends Seeder
{
    public function run()
    {
        // Obtener cuentas bancarias disponibles
        $cuentas = CuentaBancaria::with('moneda')->where('activa', true)->get();
        
        if ($cuentas->count() < 2) {
            $this->command->info('Se necesitan al menos 2 cuentas bancarias activas para crear traspasos.');
            return;
        }

        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password')
            ]);
        }

        // Obtener moneda MXN y USD
        $monedaMxn = Moneda::where('codigo', 'MXN')->first();
        $monedaUsd = Moneda::where('codigo', 'USD')->first();

        // Seleccionar cuentas de prueba
        $cuenta1 = $cuentas->first();
        $cuenta2 = $cuentas->skip(1)->first();
        
        // Traspasos de ejemplo
        $traspasos = [
            [
                'folio' => 'TRAS-202601-0001',
                'fecha' => '2026-01-15',
                'monto' => 50000.00,
                'concepto' => 'Traspaso para pago de proveedores',
                'cuenta_origen_id' => $cuenta1->id,
                'cuenta_destino_id' => $cuenta2->id,
                'moneda_origen_id' => $monedaMxn->id,
                'moneda_destino_id' => $monedaMxn->id,
                'tipo_cambio' => 1.0000,
                'monto_destino' => 50000.00,
                'estatus' => 'completado',
                'referencia' => 'REF-001',
                'referencia_bancaria' => 'BAN-001',
                'poliza_contable' => 'POL-001',
                'observaciones' => 'Traspaso realizado correctamente',
                'created_by' => $user->id
            ],
            [
                'folio' => 'TRAS-202601-0002',
                'fecha' => '2026-01-20',
                'monto' => 75000.00,
                'concepto' => 'Traspaso para inversión',
                'cuenta_origen_id' => $cuenta2->id,
                'cuenta_destino_id' => $cuenta1->id,
                'moneda_origen_id' => $monedaMxn->id,
                'moneda_destino_id' => $monedaMxn->id,
                'tipo_cambio' => 1.0000,
                'monto_destino' => 75000.00,
                'estatus' => 'procesado',
                'referencia' => 'REF-002',
                'referencia_bancaria' => 'BAN-002',
                'poliza_contable' => 'POL-002',
                'observaciones' => 'Traspaso en proceso',
                'created_by' => $user->id
            ],
            [
                'folio' => 'TRAS-202601-0003',
                'fecha' => '2026-01-25',
                'monto' => 32000.00,
                'concepto' => 'Traspaso para pago de nómina',
                'cuenta_origen_id' => $cuenta1->id,
                'cuenta_destino_id' => $cuenta2->id,
                'moneda_origen_id' => $monedaMxn->id,
                'moneda_destino_id' => $monedaMxn->id,
                'tipo_cambio' => 1.0000,
                'monto_destino' => 32000.00,
                'estatus' => 'pendiente',
                'referencia' => 'REF-003',
                'referencia_bancaria' => 'BAN-003',
                'poliza_contable' => 'POL-003',
                'observaciones' => 'Pendiente de autorización',
                'created_by' => $user->id
            ],
            [
                'folio' => 'TRAS-202601-0004',
                'fecha' => '2026-01-30',
                'monto' => 125000.00,
                'concepto' => 'Traspaso entre cuentas en USD',
                'cuenta_origen_id' => $cuenta1->id,
                'cuenta_destino_id' => $cuenta2->id,
                'moneda_origen_id' => $monedaUsd->id,
                'moneda_destino_id' => $monedaMxn->id,
                'tipo_cambio' => 20.50,
                'monto_destino' => 2562500.00,
                'estatus' => 'completado',
                'referencia' => 'REF-004',
                'referencia_bancaria' => 'BAN-004',
                'poliza_contable' => 'POL-004',
                'observaciones' => 'Traspaso con tipo de cambio aplicado',
                'created_by' => $user->id
            ],
            [
                'folio' => 'TRAS-202601-0005',
                'fecha' => '2026-02-01',
                'monto' => 89000.00,
                'concepto' => 'Traspaso para gastos operativos',
                'cuenta_origen_id' => $cuenta2->id,
                'cuenta_destino_id' => $cuenta1->id,
                'moneda_origen_id' => $monedaMxn->id,
                'moneda_destino_id' => $monedaMxn->id,
                'tipo_cambio' => 1.0000,
                'monto_destino' => 89000.00,
                'estatus' => 'cancelado',
                'referencia' => 'REF-005',
                'referencia_bancaria' => 'BAN-005',
                'poliza_contable' => null,
                'observaciones' => 'Traspaso cancelado por solicitud',
                'created_by' => $user->id
            ],
            [
                'folio' => 'TRAS-202602-0006',
                'fecha' => '2026-02-05',
                'monto' => 23400.00,
                'concepto' => 'Traspaso para pago de servicios',
                'cuenta_origen_id' => $cuenta1->id,
                'cuenta_destino_id' => $cuenta2->id,
                'moneda_origen_id' => $monedaMxn->id,
                'moneda_destino_id' => $monedaMxn->id,
                'tipo_cambio' => 1.0000,
                'monto_destino' => 23400.00,
                'estatus' => 'completado',
                'referencia' => 'REF-006',
                'referencia_bancaria' => 'BAN-006',
                'poliza_contable' => 'POL-006',
                'observaciones' => null,
                'created_by' => $user->id
            ],
            [
                'folio' => 'TRAS-202602-0007',
                'fecha' => '2026-02-10',
                'monto' => 56700.00,
                'concepto' => 'Traspaso para inversión en USD',
                'cuenta_origen_id' => $cuenta2->id,
                'cuenta_destino_id' => $cuenta1->id,
                'moneda_origen_id' => $monedaMxn->id,
                'moneda_destino_id' => $monedaUsd->id,
                'tipo_cambio' => 20.80,
                'monto_destino' => 2725.96,
                'estatus' => 'procesado',
                'referencia' => 'REF-007',
                'referencia_bancaria' => 'BAN-007',
                'poliza_contable' => 'POL-007',
                'observaciones' => 'Conversión a USD',
                'created_by' => $user->id
            ],
            [
                'folio' => 'TRAS-202602-0008',
                'fecha' => '2026-02-15',
                'monto' => 178900.00,
                'concepto' => 'Traspaso mayor para proyecto',
                'cuenta_origen_id' => $cuenta1->id,
                'cuenta_destino_id' => $cuenta2->id,
                'moneda_origen_id' => $monedaMxn->id,
                'moneda_destino_id' => $monedaMxn->id,
                'tipo_cambio' => 1.0000,
                'monto_destino' => 178900.00,
                'estatus' => 'pendiente',
                'referencia' => 'REF-008',
                'referencia_bancaria' => 'BAN-008',
                'poliza_contable' => 'POL-008',
                'observaciones' => 'Requiere autorización especial',
                'created_by' => $user->id
            ]
        ];

        foreach ($traspasos as $data) {
            Traspaso::create($data);
        }

        $this->command->info('Seeder de Traspasos ejecutado correctamente. Se crearon ' . count($traspasos) . ' registros.');
    }
}