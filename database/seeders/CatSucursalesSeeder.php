<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CatSucursalesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cat_sucursales')->insert([
            [
                'cat_sucursal_id' => 1,
                'nombre' => 'Matriz',
                'codigo' => '001',
                'calle' => 'Av Principal',
                'num_exterior' => '100',
                'num_interior' => null,
                'colonia' => 'Centro',
                'codigo_postal' => '64000',
                'municipio' => 'Monterrey',
                'estado' => 'Nuevo León',
                'pais' => 'MEX',
                'email' => 'matriz@empresa.com',
                'telefono' => '8188880000',
                'datos_generales_id' => 1,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'cat_sucursal_id' => 2,
                'nombre' => 'Sucursal Norte',
                'codigo' => '002',
                'calle' => 'Av Industrial',
                'num_exterior' => '500',
                'num_interior' => null,
                'colonia' => 'Parque Industrial',
                'codigo_postal' => '66600',
                'municipio' => 'Apodaca',
                'estado' => 'Nuevo León',
                'pais' => 'MEX',
                'email' => 'norte@empresa.com',
                'telefono' => '8188881111',
                'datos_generales_id' => 1,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
        ]);

        // Resetear la secuencia
        $hasSequence = DB::select("SELECT 1 FROM information_schema.sequences WHERE sequence_name = 'cat_sucursales_cat_sucursal_id_seq'");
        if (!empty($hasSequence)) {
            DB::statement("SELECT setval('cat_sucursales_cat_sucursal_id_seq', (SELECT MAX(cat_sucursal_id) FROM cat_sucursales));");
        }

        $this->command->info('Sucursales insertadas correctamente!');
    }
}