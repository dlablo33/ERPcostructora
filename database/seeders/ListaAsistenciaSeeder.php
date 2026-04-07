<?php

namespace Database\Seeders;

use App\Models\ListaAsistencia;
use App\Models\DetalleListaAsistencia;
use App\Models\Plantilla;
use Illuminate\Database\Seeder;

class ListaAsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        $fechas = ['2025-03-27', '2025-03-26', '2025-03-25'];
        
        $empleados = Plantilla::where('activo', 1)
            ->limit(10)
            ->get();
        
        foreach ($fechas as $fecha) {
            $lista = ListaAsistencia::create([
                'folio' => ListaAsistencia::generarFolio($fecha),
                'fecha' => $fecha,
                'total_empleados' => $empleados->count(),
                'presentes' => 0,
                'retardos' => 0,
                'ausentes' => 0,
                'justificados' => 0,
                'cerrada' => false,
                'creado_por' => 1
            ]);
            
            foreach ($empleados as $emp) {
                $estado = ['presente', 'presente', 'presente', 'retardo', 'ausente'][rand(0, 4)];
                $horaEntrada = $estado == 'presente' ? '09:00' : ($estado == 'retardo' ? '09:30' : null);
                $horaSalida = $estado == 'presente' || $estado == 'retardo' ? '18:00' : null;
                
                DetalleListaAsistencia::create([
                    'lista_asistencia_id' => $lista->id,
                    'empleado_id' => $emp->plantilla_id,
                    'empleado_nombre' => $emp->nombre . ' ' . $emp->apellido_paterno,
                    'puesto' => $emp->puesto,
                    'hora_entrada' => $horaEntrada,
                    'hora_salida' => $horaSalida,
                    'estado' => $estado,
                    'horas_trabajadas' => ($horaEntrada && $horaSalida) ? 8 : 0,
                    'justificado' => $estado == 'ausente' ? rand(0, 1) : false
                ]);
            }
            
            $lista->actualizarEstadisticas();
        }
    }
}