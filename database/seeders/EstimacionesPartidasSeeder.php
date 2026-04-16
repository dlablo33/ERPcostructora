<?php
// database/seeders/EstimacionesPartidasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\ProyectoPartida;

class EstimacionesPartidasSeeder extends Seeder
{
    public function run()
    {
        // Obtener el primer proyecto
        $proyecto = Proyecto::first();
        if (!$proyecto) {
            $this->command->error('No hay proyectos en la base de datos');
            return;
        }
        
        // Obtener partidas del proyecto
        $partidas = ProyectoPartida::where('proyecto_id', $proyecto->id)->get();
        
        if ($partidas->count() == 0) {
            $this->command->error('No hay partidas para el proyecto');
            return;
        }
        
        $estimaciones = [];
        
        // Fechas de estimaciones (mensuales)
        $fechas = [
            '2026-01-15' => 15,  // Enero 15%
            '2026-02-15' => 30,  // Febrero 30% (acumulado)
            '2026-03-15' => 45,  // Marzo 45%
            '2026-04-15' => 55,  // Abril 55%
        ];
        
        foreach ($partidas as $partida) {
            foreach ($fechas as $fecha => $avance) {
                // Calcular cantidad ejecutada (proporcional)
                $cantidadEjecutada = ($avance / 100) * $partida->cantidad;
                
                $estimaciones[] = [
                    'proyecto_id' => $proyecto->id,
                    'partida_id' => $partida->id,
                    'fecha' => $fecha,
                    'periodo_inicio' => date('Y-m-01', strtotime($fecha)),
                    'periodo_fin' => date('Y-m-t', strtotime($fecha)),
                    'avance_porcentaje' => $avance,
                    'cantidad_ejecutada' => round($cantidadEjecutada, 2),
                    'observaciones' => "Estimación de avance - " . date('F Y', strtotime($fecha)),
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Insertar estimaciones
        foreach ($estimaciones as $estimacion) {
            DB::table('estimaciones_partidas')->insert($estimacion);
        }
         
        $this->command->info('✅ ' . count($estimaciones) . ' estimaciones creadas');
        $this->command->info('   Proyecto: ' . $proyecto->nombre);
        $this->command->info('   Partidas: ' . $partidas->count());
    }
}