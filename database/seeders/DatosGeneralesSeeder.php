<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatosGeneralesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('datos_generales')->insert([
            'datos_generales_id' => 1,
            'razon_social' => 'EMPRESA DE PRUEBA SA DE CV',
            'rfc' => 'EPS123456789',
            'calle' => 'Av Principal',
            'num_exterior' => '100',
            'num_interior' => null,
            'colonia' => 'Centro',
            'codigo_postal' => '64000',
            'municipio' => 'Monterrey',
            'estado' => 'Nuevo León',
            'pais' => 'MEX',
            'satcat_regimen_fiscal_clave' => '601',
            'logo_path' => null,
            'certificado_cer' => null,
            'certificado_key' => null,
            'certificado_password' => null,
            'certificado_no_serie' => null,
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        $this->command->info('Datos generales insertados correctamente!');
    }
}