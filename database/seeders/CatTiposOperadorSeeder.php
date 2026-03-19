<?php

namespace Database\Seeders;

use App\Models\CatTipoOperador;
use Illuminate\Database\Seeder;

class CatTiposOperadorSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['tipo_operador' => 'Operador de Carga', 'descripcion' => 'Operador de unidades de carga', 'activo' => true],
            ['tipo_operador' => 'Operador de Pasaje', 'descripcion' => 'Operador de unidades de pasaje', 'activo' => true],
            ['tipo_operador' => 'Operador de Maquinaria', 'descripcion' => 'Operador de maquinaria pesada', 'activo' => true],
            ['tipo_operador' => 'Operador de Grúa', 'descripcion' => 'Operador de grúas', 'activo' => true],
            ['tipo_operador' => 'Operador de Montacargas', 'descripcion' => 'Operador de montacargas', 'activo' => true],
            ['tipo_operador' => 'Operador de Tractocamión', 'descripcion' => 'Operador de tractocamiones', 'activo' => true],
            ['tipo_operador' => 'Operador de Autobús', 'descripcion' => 'Operador de autobuses', 'activo' => true],
        ];

        foreach ($tipos as $tipo) {
            CatTipoOperador::updateOrCreate(
                ['tipo_operador' => $tipo['tipo_operador']],
                $tipo
            );
        }
    }
}