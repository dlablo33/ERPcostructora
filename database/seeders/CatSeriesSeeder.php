<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CatSeriesSeeder extends Seeder
{
    public function run(): void
    {
        // Primero asegurar que existe datos_generales_id = 1
        $datosGenerales = DB::table('datos_generales')->where('datos_generales_id', 1)->first();
        
        if (!$datosGenerales) {
            $this->command->error('Primero ejecuta DatosGeneralesSeeder');
            return;
        }
        
        DB::table('cat_series')->insert([
            [
                'cat_serie_id' => 1,
                'serie' => 'F',
                'descripcion' => 'Facturas',
                'datos_generales_id' => 1,
                'cat_tipo_comprobante' => 'I',
                'folio_actual' => 0,
                'folio_final' => 99999,
                'satcat_csd_id' => null,
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'cat_serie_id' => 2,
                'serie' => 'A',
                'descripcion' => 'Facturas Serie A',
                'datos_generales_id' => 1,
                'cat_tipo_comprobante' => 'I',
                'folio_actual' => 0,
                'folio_final' => 99999,
                'satcat_csd_id' => null,
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'cat_serie_id' => 3,
                'serie' => 'B',
                'descripcion' => 'Facturas Serie B',
                'datos_generales_id' => 1,
                'cat_tipo_comprobante' => 'I',
                'folio_actual' => 0,
                'folio_final' => 99999,
                'satcat_csd_id' => null,
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'cat_serie_id' => 4,
                'serie' => 'NC',
                'descripcion' => 'Notas de Crédito',
                'datos_generales_id' => 1,
                'cat_tipo_comprobante' => 'N',
                'folio_actual' => 0,
                'folio_final' => 99999,
                'satcat_csd_id' => null,
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Resetear la secuencia
        $hasSequence = DB::select("SELECT 1 FROM information_schema.sequences WHERE sequence_name = 'cat_series_cat_serie_id_seq'");
        if (!empty($hasSequence)) {
            DB::statement("SELECT setval('cat_series_cat_serie_id_seq', (SELECT MAX(cat_serie_id) FROM cat_series));");
        }

        $this->command->info('Series insertadas correctamente!');
    }
}