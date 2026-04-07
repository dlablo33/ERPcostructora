<?php

namespace App\Observers;

use App\Models\Asistencia;
use App\Models\ListaAsistencia;
use App\Models\DetalleListaAsistencia;
use App\Models\Plantilla;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsistenciaObserver
{
    /**
     * Handle the Asistencia "created" event.
     */
    public function created(Asistencia $asistencia): void
    {
        $this->sincronizarLista($asistencia);
    }

    /**
     * Handle the Asistencia "updated" event.
     */
    public function updated(Asistencia $asistencia): void
    {
        $this->sincronizarLista($asistencia);
    }

    /**
     * Handle the Asistencia "deleted" event.
     */
    public function deleted(Asistencia $asistencia): void
    {
        $this->actualizarLista($asistencia->fecha);
    }

    /**
     * Sincronizar la lista de asistencia con el registro
     */
    private function sincronizarLista(Asistencia $asistencia): void
    {
        try {
            DB::beginTransaction();
            
            $fecha = $asistencia->fecha;
            $empleadoId = $asistencia->plantilla_id ?? $asistencia->user_id;
            
            // Buscar o crear la lista de asistencia para esta fecha
            $lista = ListaAsistencia::where('fecha', $fecha)->first();
            
            if (!$lista) {
                // Crear nueva lista con todos los empleados activos
                $empleadosActivos = Plantilla::where('estatus', 'Activo')
                    ->orWhere('estatus', '1')
                    ->get();
                
                $folio = ListaAsistencia::generarFolio($fecha);
                
                $lista = ListaAsistencia::create([
                    'folio' => $folio,
                    'fecha' => $fecha,
                    'total_empleados' => $empleadosActivos->count(),
                    'presentes' => 0,
                    'retardos' => 0,
                    'ausentes' => $empleadosActivos->count(),
                    'justificados' => 0,
                    'cerrada' => false,
                    'creado_por' => auth()->id() ?? 1
                ]);
                
                // Crear detalles para todos los empleados
                foreach ($empleadosActivos as $empleado) {
                    DetalleListaAsistencia::create([
                        'lista_asistencia_id' => $lista->id,
                        'empleado_id' => $empleado->plantilla_id,
                        'empleado_nombre' => $empleado->nombre_completo,
                        'puesto' => $empleado->puesto ? $empleado->puesto->nombre : 'N/A',
                        'estado' => 'ausente'
                    ]);
                }
            }
            
            // Buscar o crear el detalle para este empleado
            $detalle = DetalleListaAsistencia::where('lista_asistencia_id', $lista->id)
                ->where('empleado_id', $empleadoId)
                ->first();
            
            // Determinar el estado basado en la asistencia
            $estado = 'ausente';
            if ($asistencia->estatus == 'Activo') {
                $estado = 'presente';
            } elseif ($asistencia->estatus == 'Retardo') {
                $estado = 'retardo';
            } elseif ($asistencia->estatus == 'Justificado') {
                $estado = 'justificado';
            }
            
            // Calcular horas trabajadas
            $horasTrabajadas = 0;
            if ($asistencia->hora_entrada && $asistencia->hora_salida) {
                $entrada = new \DateTime($asistencia->hora_entrada);
                $salida = new \DateTime($asistencia->hora_salida);
                $interval = $entrada->diff($salida);
                $horasTrabajadas = $interval->h + ($interval->i / 60);
                if ($horasTrabajadas > 5) {
                    $horasTrabajadas -= 1;
                }
            }
            
            if ($detalle) {
                // Actualizar detalle existente
                $detalle->update([
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $asistencia->hora_salida,
                    'estado' => $estado,
                    'observaciones' => $asistencia->observaciones,
                    'horas_trabajadas' => $horasTrabajadas,
                    'justificado' => $asistencia->estatus == 'Justificado'
                ]);
            } else {
                // Crear nuevo detalle
                DetalleListaAsistencia::create([
                    'lista_asistencia_id' => $lista->id,
                    'empleado_id' => $empleadoId,
                    'empleado_nombre' => $asistencia->nombre_persona ?? 'Empleado',
                    'puesto' => $this->obtenerPuestoEmpleado($empleadoId),
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $asistencia->hora_salida,
                    'estado' => $estado,
                    'observaciones' => $asistencia->observaciones,
                    'horas_trabajadas' => $horasTrabajadas,
                    'justificado' => $asistencia->estatus == 'Justificado'
                ]);
            }
            
            // Actualizar estadísticas de la lista
            $lista->actualizarEstadisticas();
            
            DB::commit();
            
            Log::info("Lista de asistencia sincronizada para fecha {$fecha}", [
                'lista_id' => $lista->id,
                'empleado_id' => $empleadoId,
                'estado' => $estado
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al sincronizar lista de asistencia: " . $e->getMessage());
        }
    }
    
    /**
     * Actualizar lista completa para una fecha
     */
    private function actualizarLista($fecha): void
    {
        try {
            $lista = ListaAsistencia::where('fecha', $fecha)->first();
            if ($lista) {
                $lista->actualizarEstadisticas();
            }
        } catch (\Exception $e) {
            Log::error("Error al actualizar lista: " . $e->getMessage());
        }
    }
    
    /**
     * Obtener puesto del empleado
     */
    private function obtenerPuestoEmpleado($empleadoId)
    {
        try {
            $empleado = Plantilla::with('puesto')->find($empleadoId);
            return $empleado && $empleado->puesto ? $empleado->puesto->nombre : 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}