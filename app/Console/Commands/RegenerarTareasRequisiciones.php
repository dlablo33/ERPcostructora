<?php

namespace App\Console\Commands;

use App\Models\Requisicion;
use App\Models\WorkflowTask;
use Illuminate\Console\Command;

class RegenerarTareasRequisiciones extends Command
{
    protected $signature = 'requisiciones:regenerar-tareas 
                            {--force : Forzar regeneración aunque ya tengan tarea}
                            {--id= : Procesar solo una requisición específica}';
                            
    protected $description = 'Regenera tareas para todas las requisiciones que no tienen tarea';

    public function handle()
    {
        $this->info('🔄 Iniciando regeneración de tareas para requisiciones...');
        
        // Si se especifica un ID, procesar solo esa requisición
        if ($this->option('id')) {
            $requisicion = Requisicion::find($this->option('id'));
            if (!$requisicion) {
                $this->error("❌ Requisición ID {$this->option('id')} no encontrada");
                return 1;
            }
            return $this->procesarRequisicion($requisicion);
        }
        
        // Obtener todas las requisiciones
        $requisiciones = Requisicion::all();
        $total = $requisiciones->count();
        
        if ($total === 0) {
            $this->info('⚠️ No hay requisiciones en la base de datos.');
            return 0;
        }
        
        $this->info("📊 Se encontraron {$total} requisiciones.");
        
        // Separar las que tienen y no tienen tarea
        $conTarea = [];
        $sinTarea = [];
        
        foreach ($requisiciones as $req) {
            $tarea = WorkflowTask::where('module', 'requisiciones')
                ->where('record_id', $req->id)
                ->first();
            
            if ($tarea) {
                $conTarea[] = $req;
            } else {
                $sinTarea[] = $req;
            }
        }
        
        $this->table(
            ['Concepto', 'Cantidad'],
            [
                ['Total requisiciones', $total],
                ['Con tarea existente', count($conTarea)],
                ['Sin tarea (a procesar)', count($sinTarea)]
            ]
        );
        
        // Determinar qué procesar
        if ($this->option('force')) {
            $aProcesar = $requisiciones;
            $this->warn('⚠️ Modo FORCE activado - Se regenerarán TODAS las tareas');
        } else {
            $aProcesar = $sinTarea;
            if (count($aProcesar) === 0) {
                $this->info('✅ Todas las requisiciones ya tienen tarea.');
                $this->info('💡 Usa --force para regenerar todas las tareas.');
                return 0;
            }
        }
        
        $totalProcesar = count($aProcesar);
        $this->info("📋 Se procesarán {$totalProcesar} requisiciones.");
        
        // Procesar
        $bar = $this->output->createProgressBar($totalProcesar);
        $generadas = 0;
        $errores = 0;
        $detalles = [];
        
        foreach ($aProcesar as $requisicion) {
            $resultado = $this->procesarRequisicion($requisicion);
            
            if ($resultado['success']) {
                $generadas++;
                $detalles[] = [
                    'folio' => $requisicion->folio,
                    'tarea_id' => $resultado['tarea_id'] ?? 'N/A',
                    'status' => '✅ OK'
                ];
            } else {
                $errores++;
                $detalles[] = [
                    'folio' => $requisicion->folio,
                    'tarea_id' => 'N/A',
                    'status' => '❌ ' . ($resultado['message'] ?? 'Error')
                ];
                // Mostrar error detallado
                $this->error("\n❌ Error en requisición {$requisicion->folio}: " . ($resultado['message'] ?? 'Error desconocido'));
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        // Mostrar resultados
        $this->info("📊 Resumen final:");
        $this->table(
            ['Concepto', 'Cantidad'],
            [
                ['Total procesadas', $totalProcesar],
                ['Tareas generadas', $generadas],
                ['Errores', $errores]
            ]
        );
        
        if ($errores > 0) {
            $this->warn("\n⚠️ Detalle de errores:");
            $this->table(
                ['Folio', 'Estado'],
                array_filter($detalles, function($d) {
                    return strpos($d['status'], '❌') !== false;
                })
            );
        }
        
        // Mostrar últimas tareas creadas
        $ultimasTareas = WorkflowTask::where('module', 'requisiciones')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        if ($ultimasTareas->count() > 0) {
            $this->info("\n📋 Últimas tareas generadas:");
            $this->table(
                ['ID', 'Título', 'Estado', 'Prioridad', 'Creada'],
                $ultimasTareas->map(function($t) {
                    return [
                        $t->id,
                        substr($t->title, 0, 40),
                        $t->status,
                        $t->priority,
                        $t->created_at->diffForHumans()
                    ];
                })->toArray()
            );
        }
        
        return $errores > 0 ? 1 : 0;
    }

    /**
     * Procesa una requisición individual
     */
    private function procesarRequisicion($requisicion)
    {
        try {
            $this->line("\n🔍 Procesando: {$requisicion->folio} (ID: {$requisicion->id})");
            
            // Verificar si el método existe
            if (!method_exists($requisicion, 'generarTareaDesdeRequisicion')) {
                $this->error("❌ El método generarTareaDesdeRequisicion no existe");
                return [
                    'success' => false,
                    'message' => 'Método no encontrado'
                ];
            }
            
            // Si es force, eliminar tarea existente primero
            if ($this->option('force')) {
                $tareaExistente = WorkflowTask::where('module', 'requisiciones')
                    ->where('record_id', $requisicion->id)
                    ->first();
                
                if ($tareaExistente) {
                    $tareaExistente->delete();
                    $this->line("🗑️ Tarea eliminada para requisición {$requisicion->folio}");
                }
            }
            
            // Generar nueva tarea
            $this->line("⏳ Generando tarea...");
            $tarea = $requisicion->generarTareaDesdeRequisicion();
            
            if ($tarea) {
                $this->line("✅ Tarea generada (ID: {$tarea->id})");
                return [
                    'success' => true,
                    'tarea_id' => $tarea->id,
                    'message' => 'Tarea generada'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'La generación retornó null'
                ];
            }
            
        } catch (\Exception $e) {
            $this->error("❌ ERROR: " . $e->getMessage());
            $this->error("📁 Archivo: " . $e->getFile() . ":" . $e->getLine());
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}