<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contactos')->insert([
            [
                'contacto_id' => 1,
                'razon_social' => 'MAQUILADORA INDUSTRIAL SA DE CV',
                'rfc' => 'MII880101ABC',
                'nombre_comercial' => 'Maquiladora Industrial',
                'email_facturacion' => 'facturacion@maquiladora.com.mx',
                'telefono' => '8188881111',
                'satcat_regimen_fiscal_clave' => '601',
                'satcat_uso_cfdi_clave' => 'G01',
                'satcat_formas_pago_clave' => '01',
                'satcat_metodos_pago_clave' => 'PUE',
                'calle' => 'Av Industrial',
                'num_exterior' => '123',
                'num_interior' => null,
                'colonia' => 'Parque Industrial',
                'codigo_postal' => '66600',
                'municipio' => 'Apodaca',
                'estado' => 'Nuevo Leon',
                'pais' => 'MEX',  // ← 3 caracteres máximo
                'tipo' => 'cliente',
                'dias_credito' => 30,
                'limite_credito' => 1000000.00,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'contacto_id' => 2,
                'razon_social' => 'CARTONES DEL NORTE SAPI DE CV',
                'rfc' => 'CND890202XYZ',
                'nombre_comercial' => 'Cartones del Norte',
                'email_facturacion' => 'facturas@cartonesnorte.com.mx',
                'telefono' => '8188882222',
                'satcat_regimen_fiscal_clave' => '601',
                'satcat_uso_cfdi_clave' => 'G01',
                'satcat_formas_pago_clave' => '02',
                'satcat_metodos_pago_clave' => 'PPD',
                'calle' => 'Blvd Miguel Aleman',
                'num_exterior' => '456',
                'num_interior' => null,
                'colonia' => 'Centro',
                'codigo_postal' => '66000',
                'municipio' => 'Escobedo',
                'estado' => 'Nuevo Leon',
                'pais' => 'MEX',  // ← 3 caracteres máximo
                'tipo' => 'cliente',
                'dias_credito' => 45,
                'limite_credito' => 1500000.00,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'contacto_id' => 3,
                'razon_social' => 'TRANSPORTES DEL BAJIO SRL',
                'rfc' => 'TBA890123XYZ',
                'nombre_comercial' => 'Transportes del Bajio',
                'email_facturacion' => 'admin@transportesbajio.com',
                'telefono' => '4778883333',
                'satcat_regimen_fiscal_clave' => '603',
                'satcat_uso_cfdi_clave' => 'G03',
                'satcat_formas_pago_clave' => '03',
                'satcat_metodos_pago_clave' => 'PUE',
                'calle' => 'Carretera Leon-Silao',
                'num_exterior' => 'KM 5',
                'num_interior' => null,
                'colonia' => 'Parque Logistico',
                'codigo_postal' => '37000',
                'municipio' => 'Leon',
                'estado' => 'Guanajuato',
                'pais' => 'MEX',  // ← 3 caracteres máximo
                'tipo' => 'cliente',
                'dias_credito' => 15,
                'limite_credito' => 500000.00,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'contacto_id' => 4,
                'razon_social' => 'LOGISTICA MONTERREY SA DE CV',
                'rfc' => 'LMN890456ABC',
                'nombre_comercial' => 'Logistica Monterrey',
                'email_facturacion' => 'facturacion@logisticamty.com',
                'telefono' => '8188884444',
                'satcat_regimen_fiscal_clave' => '601',
                'satcat_uso_cfdi_clave' => 'G02',
                'satcat_formas_pago_clave' => '01',
                'satcat_metodos_pago_clave' => 'PUE',
                'calle' => 'Av Gonzalitos',
                'num_exterior' => '789',
                'num_interior' => 'Piso 3',
                'colonia' => 'Contry',
                'codigo_postal' => '64800',
                'municipio' => 'Monterrey',
                'estado' => 'Nuevo Leon',
                'pais' => 'MEX',  // ← 3 caracteres máximo
                'tipo' => 'cliente',
                'dias_credito' => 30,
                'limite_credito' => 800000.00,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'contacto_id' => 5,
                'razon_social' => 'COMERCIALIZADORA DEL SUR SA',
                'rfc' => 'CDS890123DEF',
                'nombre_comercial' => 'Comercializadora del Sur',
                'email_facturacion' => 'ventas@comercializadorasur.com',
                'telefono' => '9998885555',
                'satcat_regimen_fiscal_clave' => '605',
                'satcat_uso_cfdi_clave' => 'G01',
                'satcat_formas_pago_clave' => '02',
                'satcat_metodos_pago_clave' => 'PPD',
                'calle' => 'Calle 60',
                'num_exterior' => '321',
                'num_interior' => null,
                'colonia' => 'Centro',
                'codigo_postal' => '97000',
                'municipio' => 'Merida',
                'estado' => 'Yucatan',
                'pais' => 'MEX',  // ← 3 caracteres máximo
                'tipo' => 'cliente',
                'dias_credito' => 60,
                'limite_credito' => 2000000.00,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'contacto_id' => 6,
                'razon_social' => 'CONSTRUCTORA DEL CENTRO SAB DE CV',
                'rfc' => 'CCS890456GHI',
                'nombre_comercial' => 'Constructora del Centro',
                'email_facturacion' => 'facturas@constructora.com.mx',
                'telefono' => '4428886666',
                'satcat_regimen_fiscal_clave' => '601',
                'satcat_uso_cfdi_clave' => 'G03',
                'satcat_formas_pago_clave' => '03',
                'satcat_metodos_pago_clave' => 'PUE',
                'calle' => 'Av Universidad',
                'num_exterior' => '1234',
                'num_interior' => null,
                'colonia' => 'Juriquilla',
                'codigo_postal' => '76230',
                'municipio' => 'Queretaro',
                'estado' => 'Queretaro',
                'pais' => 'MEX',  // ← 3 caracteres máximo
                'tipo' => 'cliente',
                'dias_credito' => 45,
                'limite_credito' => 3000000.00,
                'estatus' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ]
        ]);

        // Resetear la secuencia si existe
        $hasSequence = DB::select("SELECT 1 FROM information_schema.sequences WHERE sequence_name = 'contactos_contacto_id_seq'");
        if (!empty($hasSequence)) {
            DB::statement("SELECT setval('contactos_contacto_id_seq', (SELECT MAX(contacto_id) FROM contactos));");
        }

        $this->command->info('Contactos insertados correctamente!');
    }
}