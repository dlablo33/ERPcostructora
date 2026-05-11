<?php
// database/migrations/2026_05_06_182203_add_nota_credito_series_to_cat_series_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Verificar si la serie NC ya existe
        $ncExists = DB::table('cat_series')->where('serie', 'NC')->exists();
        $ncrExists = DB::table('cat_series')->where('serie', 'NCR')->exists();
        
        // Solo insertar si no existen
        if (!$ncExists) {
            DB::table('cat_series')->insert([
                'cat_serie_id' => 10,
                'serie' => 'NC',
                'descripcion' => 'Notas de Crédito',
                'datos_generales_id' => 1,
                'cat_tipo_comprobante' => 'E',
                'folio_actual' => 0,
                'folio_final' => 99999,
                'satcat_csd_id' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        if (!$ncrExists) {
            DB::table('cat_series')->insert([
                'cat_serie_id' => 11,
                'serie' => 'NCR',
                'descripcion' => 'Notas de Crédito - RFC',
                'datos_generales_id' => 1,
                'cat_tipo_comprobante' => 'E',
                'folio_actual' => 0,
                'folio_final' => 99999,
                'satcat_csd_id' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Actualizar secuencia si es necesario
        $maxId = DB::table('cat_series')->max('cat_serie_id');
        DB::statement("SELECT setval('cat_series_cat_serie_id_seq', (SELECT MAX(cat_serie_id) FROM cat_series));");
    }

    public function down()
    {
        // No eliminamos para no afectar datos existentes
        // Solo eliminamos si fueron creadas por esta migración
        DB::table('cat_series')->whereIn('cat_serie_id', [10, 11])->delete();
    }
};