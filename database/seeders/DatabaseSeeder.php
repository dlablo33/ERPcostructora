<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Catálogos básicos de RH
            CatAreasSeeder::class,
            CatPuestosSeeder::class,
            CatBancosSeeder::class,
            CatTiposCuentaSeeder::class,
            CatTiposOperadorSeeder::class,
            CatTiposLicenciaSeeder::class,
            CatEstatusSeeder::class,
            CatUnidadesNegocioSeeder::class,
            
            // Catálogos SAT para dirección y nómina
            SatcatPaisesSeeder::class,
            SatcatEstadosSeeder::class,
            // Nota: Los siguientes seeders requieren que existan los anteriores
            // SatcatMunicipiosSeeder::class, // Opcional - muchos registros
            // SatcatLocalidadesSeeder::class, // Opcional - muchos registros
            // SatcatCodigosPostalesSeeder::class, // Opcional - muchos registros
            // SatcatColoniasSeeder::class, // Opcional - muchos registros
            
            // Catálogos SAT para nómina
            SatcatNominaContratosSeeder::class,
            SatcatNominaJornadasSeeder::class,
            SatcatNominaPeriodicidadesSeeder::class,
            SatcatNominaRegimenesSeeder::class,
            SatcatFigurasTransporteSeeder::class,
            
            // Seeders de catálogos existentes
            RolSeeder::class,
            PuestoSeeder::class,
            AreaSeeder::class,
            
            // Seeders de usuarios
            UsuarioInicialSeeder::class,
            UserSeeder::class,
            
            // Seeder de plantilla (debe ir al final porque depende de los catálogos)
            PlantillaSeeder::class,
        ]);
    }
}