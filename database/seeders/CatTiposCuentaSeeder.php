<?php

namespace Database\Seeders;

use App\Models\CatTipoCuenta;
use Illuminate\Database\Seeder;

class CatTiposCuentaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['descripcion' => 'Débito', 'clave_sat' => 'DEB', 'activo' => true],
            ['descripcion' => 'Crédito', 'clave_sat' => 'CRE', 'activo' => true],
            ['descripcion' => 'Nómina', 'clave_sat' => 'NOM', 'activo' => true],
            ['descripcion' => 'Ahorro', 'clave_sat' => 'AHO', 'activo' => true],
            ['descripcion' => 'Cheques', 'clave_sat' => 'CHE', 'activo' => true],
            ['descripcion' => 'Inversión', 'clave_sat' => 'INV', 'activo' => true],
        ];

        foreach ($tipos as $tipo) {
            CatTipoCuenta::updateOrCreate(
                ['descripcion' => $tipo['descripcion']],
                $tipo
            );
        }
    }
}