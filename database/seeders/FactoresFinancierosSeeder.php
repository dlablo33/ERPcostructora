<?php
// database/seeders/FactoresFinancierosSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FactoresFinancierosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero, obtener un usuario creador (puedes ajustar según tu sistema)
        $createdBy = DB::table('users')->where('id', 1)->exists() ? 1 : null;
        
        $factores = [
            [
                'nombre' => 'Factoraje BBVA México',
                'rfc' => 'BBVA840101LX5',
                'contacto_nombre' => 'Lic. Roberto Sánchez',
                'telefono' => '5550012345',
                'email' => 'factoraje@bbva.com',
                'direccion' => 'Paseo de la Reforma 510, Col. Juárez, CDMX',
                'porcentaje_anticipo_default' => 85.00,
                'comision_default' => 3.00,
                'dias_plazo_default' => 30,
                'activo' => true,
                'observaciones' => 'Factor líder en el mercado, acepta facturas de empresas con antigüedad mínima de 6 meses',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Santander Factoraje',
                'rfc' => 'SAN841101N93',
                'contacto_nombre' => 'Ing. Ana María López',
                'telefono' => '5550023456',
                'email' => 'factoraje@santander.com',
                'direccion' => 'Av. Ejército Nacional 843, Col. Granada, CDMX',
                'porcentaje_anticipo_default' => 80.00,
                'comision_default' => 3.50,
                'dias_plazo_default' => 45,
                'activo' => true,
                'observaciones' => 'Especialistas en factoraje para PYMEs, plazo de hasta 45 días',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Bancomer Factoraje',
                'rfc' => 'BCM850101J68',
                'contacto_nombre' => 'C.P. Carlos Méndez',
                'telefono' => '5550034567',
                'email' => 'contacto@bancomerfactoraje.com',
                'direccion' => 'Av. Insurgentes Sur 700, Col. Del Valle, CDMX',
                'porcentaje_anticipo_default' => 90.00,
                'comision_default' => 2.50,
                'dias_plazo_default' => 30,
                'activo' => true,
                'observaciones' => 'Anticipos de hasta 90%, comisiones competitivas',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Banorte Factoraje',
                'rfc' => 'BNO860101GA9',
                'contacto_nombre' => 'Lic. Patricia Reyes',
                'telefono' => '5550045678',
                'email' => 'factoraje@banorte.com',
                'direccion' => 'Av. Revolución 1500, Col. San Ángel, CDMX',
                'porcentaje_anticipo_default' => 85.00,
                'comision_default' => 3.00,
                'dias_plazo_default' => 35,
                'activo' => true,
                'observaciones' => 'Servicio personalizado y rápido en la aprobación',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'HSBC Factoraje',
                'rfc' => 'HBC870101I84',
                'contacto_nombre' => 'Ing. Ricardo Flores',
                'telefono' => '5550056789',
                'email' => 'factoraje@hsbc.com',
                'direccion' => 'Av. Paseo de la Reforma 100, Col. Lomas de Chapultepec, CDMX',
                'porcentaje_anticipo_default' => 88.00,
                'comision_default' => 3.20,
                'dias_plazo_default' => 40,
                'activo' => true,
                'observaciones' => 'Plataforma digital, respuesta en 24 horas',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Inbursa Factoraje',
                'rfc' => 'INB880101J37',
                'contacto_nombre' => 'C.P. Arturo Romero',
                'telefono' => '5550067890',
                'email' => 'factoraje@inbursa.com',
                'direccion' => 'Av. Ejército Nacional 350, Col. Polanco, CDMX',
                'porcentaje_anticipo_default' => 82.00,
                'comision_default' => 3.80,
                'dias_plazo_default' => 30,
                'activo' => true,
                'observaciones' => 'Aceptan facturas desde $50,000 MXN',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Scotiabank Factoraje',
                'rfc' => 'SCO890101EX3',
                'contacto_nombre' => 'Lic. Verónica Castro',
                'telefono' => '5550078901',
                'email' => 'factoraje@scotiabank.com',
                'direccion' => 'Av. Paseo de la Reforma 243, Col. Cuauhtémoc, CDMX',
                'porcentaje_anticipo_default' => 80.00,
                'comision_default' => 3.50,
                'dias_plazo_default' => 45,
                'activo' => true,
                'observaciones' => 'Aceptan facturas CFDI versión 3.3 y 4.0',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Afirme Factoraje',
                'rfc' => 'AFI900101E75',
                'contacto_nombre' => 'Ing. Javier Solís',
                'telefono' => '5550089012',
                'email' => 'factoraje@afirme.com',
                'direccion' => 'Av. Insurgentes Sur 1642, Col. San José Insurgentes, CDMX',
                'porcentaje_anticipo_default' => 85.00,
                'comision_default' => 3.00,
                'dias_plazo_default' => 30,
                'activo' => true,
                'observaciones' => 'Especialistas en factoraje para construcción',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Fintech Factoraje Digital',
                'rfc' => 'FID910101TL6',
                'contacto_nombre' => 'Lic. Laura Jiménez',
                'telefono' => '5550090123',
                'email' => 'contacto@fintechfactoraje.com',
                'direccion' => 'Av. Santa Fe 123, Col. Santa Fe, CDMX',
                'porcentaje_anticipo_default' => 75.00,
                'comision_default' => 4.00,
                'dias_plazo_default' => 60,
                'activo' => true,
                'observaciones' => '100% digital, aprobación en 2 horas, plazo extendido',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Kredi Factoraje',
                'rfc' => 'KRE920101D47',
                'contacto_nombre' => 'C.P. Omar González',
                'telefono' => '5550101234',
                'email' => 'factoraje@kredi.com',
                'direccion' => 'Av. Vallarta 2500, Col. Arcos Vallarta, Guadalajara, Jalisco',
                'porcentaje_anticipo_default' => 85.00,
                'comision_default' => 3.20,
                'dias_plazo_default' => 35,
                'activo' => true,
                'observaciones' => 'Factoraje sin necesidad de cuenta de cheques',
                'created_by' => $createdBy,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insertar datos
        foreach ($factores as $factor) {
            DB::table('factores_financieros')->insert($factor);
        }

        // Mostrar resultado
        $this->command->info('✅ Se insertaron ' . count($factores) . ' factores financieros exitosamente');
        $this->command->table(
            ['ID', 'Nombre', 'Anticipo %', 'Comisión %', 'Plazo (días)'],
            DB::table('factores_financieros')->where('activo', true)->get(['factor_id', 'nombre', 'porcentaje_anticipo_default', 'comision_default', 'dias_plazo_default'])->toArray()
        );
    }
}