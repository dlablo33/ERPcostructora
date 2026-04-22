<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Requisicion;
use App\Models\RequisicionArticulo;

class RequisicionesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 10 requisiciones con sus artículos
        Requisicion::factory(10)->create()->each(function ($requisicion) {
            // Cada requisición tendrá entre 1 y 5 artículos
            RequisicionArticulo::factory(rand(1, 5))->create([
                'requisicion_id' => $requisicion->id
            ]);
        });
        
        $this->command->info('Se crearon 10 requisiciones con sus artículos');
    }
}