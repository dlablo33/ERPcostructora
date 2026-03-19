<?php

namespace Database\Seeders;

use App\Models\CatBanco;
use Illuminate\Database\Seeder;

class CatBancosSeeder extends Seeder
{
    public function run(): void
    {
        $bancos = [
            ['clave' => '002', 'descripcion' => 'BANAMEX', 'nombre_corto' => 'BANAMEX', 'rfc' => 'BNM840515VB1'],
            ['clave' => '012', 'descripcion' => 'BBVA BANCOMER', 'nombre_corto' => 'BBVA', 'rfc' => 'BBVA830412I54'],
            ['clave' => '014', 'descripcion' => 'SANTANDER', 'nombre_corto' => 'SANTANDER', 'rfc' => 'SAN1406139R5'],
            ['clave' => '021', 'descripcion' => 'HSBC', 'nombre_corto' => 'HSBC', 'rfc' => 'HBC941128I44'],
            ['clave' => '022', 'descripcion' => 'GE CAPITAL', 'nombre_corto' => 'GE', 'rfc' => 'GEC941010I56'],
            ['clave' => '030', 'descripcion' => 'BAJIO', 'nombre_corto' => 'BAJIO', 'rfc' => 'BBJ8307251I2'],
            ['clave' => '032', 'descripcion' => 'IXE', 'nombre_corto' => 'IXE', 'rfc' => 'IXE940810I23'],
            ['clave' => '036', 'descripcion' => 'INBURSA', 'nombre_corto' => 'INBURSA', 'rfc' => 'INB960120I78'],
            ['clave' => '037', 'descripcion' => 'INTERACCIONES', 'nombre_corto' => 'INTERACCIONES', 'rfc' => 'INT950101I45'],
            ['clave' => '042', 'descripcion' => 'MIFEL', 'nombre_corto' => 'MIFEL', 'rfc' => 'MIF960201I67'],
            ['clave' => '044', 'descripcion' => 'SCOTIABANK', 'nombre_corto' => 'SCOTIABANK', 'rfc' => 'SBM940101I89'],
            ['clave' => '058', 'descripcion' => 'BANREGIO', 'nombre_corto' => 'BANREGIO', 'rfc' => 'BNR950301I12'],
            ['clave' => '059', 'descripcion' => 'INVEX', 'nombre_corto' => 'INVEX', 'rfc' => 'INV960401I34'],
            ['clave' => '060', 'descripcion' => 'BANSI', 'nombre_corto' => 'BANSI', 'rfc' => 'BNS970501I56'],
            ['clave' => '062', 'descripcion' => 'AFIRME', 'nombre_corto' => 'AFIRME', 'rfc' => 'AFR980601I78'],
            ['clave' => '072', 'descripcion' => 'BANORTE', 'nombre_corto' => 'BANORTE', 'rfc' => 'BNO830101I90'],
        ];

        foreach ($bancos as $banco) {
            CatBanco::updateOrCreate(
                ['clave' => $banco['clave']],
                $banco
            );
        }
    }
}