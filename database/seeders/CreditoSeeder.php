<?php

namespace Database\Seeders;

use App\Models\Banco;
use App\Models\Credito;
use Illuminate\Database\Seeder;

class CreditoSeeder extends Seeder
{
    public function run(): void
    {
        $bancos = Banco::pluck('id', 'nombre');

        $creditos = [
            ['numero_credito' => 'CRED-001', 'banco' => 'BBVA',       'fecha' => '2026-01-15', 'monto_total' => 500000, 'monto_pendiente' => 350000, 'monto_capital' => 500000, 'monto_capital_restante' => 350000, 'parcialidad_actual' => '5/24'],
            ['numero_credito' => 'CRED-002', 'banco' => 'Santander',  'fecha' => '2026-01-20', 'monto_total' => 750000, 'monto_pendiente' => 600000, 'monto_capital' => 750000, 'monto_capital_restante' => 600000, 'parcialidad_actual' => '3/36'],
            ['numero_credito' => 'CRED-003', 'banco' => 'Banamex',    'fecha' => '2026-02-01', 'monto_total' => 300000, 'monto_pendiente' => 280000, 'monto_capital' => 300000, 'monto_capital_restante' => 280000, 'parcialidad_actual' => '2/18'],
        ];

        foreach ($creditos as $c) {
            Credito::updateOrCreate(
                ['numero_credito' => $c['numero_credito']],
                [
                    'banco_id'               => $bancos[$c['banco']] ?? null,
                    'fecha'                  => $c['fecha'],
                    'monto_total'            => $c['monto_total'],
                    'monto_pendiente'        => $c['monto_pendiente'],
                    'monto_capital'          => $c['monto_capital'],
                    'monto_capital_restante' => $c['monto_capital_restante'],
                    'parcialidad_actual'     => $c['parcialidad_actual'],
                    'estado'                 => 'activo',
                ]
            );
        }
    }
}