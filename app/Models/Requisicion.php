<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Requisicion extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'requisiciones';
    
    protected $fillable = [
        'folio',
        'fecha_requerimiento',
        'estatus',
        'solicitante',
        'area',
        'area_id',
        'proyecto_id',
        'cotizadas',
        'observaciones',
        'creado_por',
        'aprobado_por',
        'fecha_aprobacion',
        'motivo_rechazo',
        'estatus_cotizacion',
        'prioridad' // Asegúrate de tener este campo
    ];
    
    protected $casts = [
        'fecha_requerimiento' => 'date',
        'fecha_aprobacion' => 'datetime',
    ];
    
    /**
     * Boot del modelo - Eventos automáticos
     */
    protected static function booted()
    {
        // Cuando se crea una requisición
        static::created(function ($requisicion) {
            $requisicion->generarTareaDesdeRequisicion();
        });

        // Cuando se actualiza una requisición
        static::updated(function ($requisicion) {
            // Si cambió el estatus a aprobada
            if ($requisicion->wasChanged('estatus') && $requisicion->estatus === 'aprobada') {
                $requisicion->actualizarTareaPorAprobacion();
            }
            
            // Si cambió el estatus de cotización a Cotizada
            if ($requisicion->wasChanged('estatus_cotizacion') && 
                $requisicion->estatus_cotizacion === 'Cotizada') {
                $requisicion->generarTareaOrdenCompra();
            }
        });
    }

    // ========== RELACIONES ==========
    
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function articulos()
    {
        return $this->hasMany(RequisicionArticulo::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
    
    public function cotizacionesArticulos()
    {
        return $this->hasManyThrough(
            CotizacionArticulo::class,
            RequisicionArticulo::class,
            'requisicion_id',
            'requisicion_articulo_id'
        );
    }

    // ========== MÉTODOS DE GENERACIÓN DE TAREAS ==========
    
    /**
 * Genera una tarea desde la requisición (al crearse)
 */
public function generarTareaDesdeRequisicion()
{
    try {
        // Verificar si ya existe una tarea para esta requisición
        $tareaExistente = WorkflowTask::where('module', 'requisiciones')
            ->where('record_id', $this->id)
            ->first();

        if ($tareaExistente) {
            return $tareaExistente;
        }

        // Obtener el ID del usuario
        $userId = $this->creado_por ?? 1;

        // Crear la tarea - EXACTAMENTE como funcionó en Tinker
        $tarea = WorkflowTask::create([
            'module' => 'requisiciones',
            'record_id' => $this->id,
            'title' => 'Requisicion: ' . ($this->folio ?? 'Sin folio'),
            'description' => 'Requisición ' . ($this->folio ?? 'Sin folio') . ' - Pendiente de revisión',
            'created_by' => $userId,
            'assigned_to' => $userId,
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => now()->addDays(3)
        ]);

        return $tarea;

    } catch (\Exception $e) {
        \Log::error('Error en generarTareaDesdeRequisicion: ' . $e->getMessage(), [
            'requisicion_id' => $this->id ?? null,
            'folio' => $this->folio ?? null
        ]);
        return null;
    }
}

    /**
     * Genera tarea para crear Orden de Compra (cuando está cotizada)
     */
    public function generarTareaOrdenCompra()
    {
        try {
            // Verificar si ya existe una tarea de OC para esta requisición
            $tareaExistente = WorkflowTask::where('module', 'requisiciones')
                ->where('record_id', $this->id)
                ->where('metadata->tipo', 'orden_compra')
                ->first();

            if ($tareaExistente) {
                return $tareaExistente;
            }

            // Buscar usuario de compras
            $usuarioCompras = User::whereHas('rol', function($query) {
                $query->where('nombre', 'Compras');
            })->first();

            $tarea = WorkflowTask::create([
                'module' => 'requisiciones',
                'record_id' => $this->id,
                'title' => "🛒 Crear Orden de Compra - " . ($this->folio ?? 'Sin folio'),
                'description' => $this->generarDescripcionOrdenCompra(),
                'created_by' => $this->creado_por ?? auth()->id(),
                'assigned_to' => $usuarioCompras->id ?? $this->creado_por ?? auth()->id(),
                'status' => 'pending',
                'priority' => 'high',
                'due_date' => now()->addDays(5),
                'metadata' => [
                    'tipo' => 'orden_compra',
                    'requisicion_id' => $this->id,
                    'folio_requisicion' => $this->folio,
                    'proyecto_id' => $this->proyecto_id,
                    'accion' => 'crear_orden_compra'
                ]
            ]);

            // Registrar en bitácora
            $this->registrarEnBitacora(
                "Orden de Compra pendiente para requisición {$this->folio}",
                "La requisición {$this->folio} está cotizada y lista para crear la Orden de Compra"
            );

            Log::info("Tarea de Orden de Compra generada", [
                'requisicion_id' => $this->id,
                'folio' => $this->folio,
                'tarea_id' => $tarea->id
            ]);

            return $tarea;

        } catch (\Exception $e) {
            Log::error("Error al generar tarea de Orden de Compra: " . $e->getMessage(), [
                'requisicion_id' => $this->id ?? null
            ]);
            return null;
        }
    }

    /**
     * Actualiza tarea cuando la requisición es aprobada
     */
    public function actualizarTareaPorAprobacion()
    {
        try {
            $tarea = WorkflowTask::where('module', 'requisiciones')
                ->where('record_id', $this->id)
                ->first();

            if ($tarea) {
                $tarea->update([
                    'status' => 'in_progress',
                    'title' => "✅ Requisición Aprobada: " . ($this->folio ?? 'Sin folio'),
                    'description' => $tarea->description . "\n\n✅ REQUISICIÓN APROBADA - Proceder con cotizaciones"
                ]);

                Log::info("Tarea actualizada por aprobación", [
                    'requisicion_id' => $this->id,
                    'folio' => $this->folio,
                    'tarea_id' => $tarea->id
                ]);
            }

        } catch (\Exception $e) {
            Log::error("Error al actualizar tarea por aprobación: " . $e->getMessage(), [
                'requisicion_id' => $this->id ?? null
            ]);
        }
    }

    // ========== MÉTODOS DE DESCRIPCIÓN ==========
    
    protected function generarDescripcionRequisicion()
    {
        $proyecto = $this->proyecto;
        $area = $this->area;
        
        $descripcion = "📋 NUEVA REQUISICIÓN REGISTRADA\n\n";
        $descripcion .= "========================================\n";
        $descripcion .= "📌 Folio: " . ($this->folio ?? 'N/A') . "\n";
        $descripcion .= "🏗️ Proyecto: " . ($proyecto->nombre ?? 'N/A') . "\n";
        $descripcion .= "📅 Fecha requerimiento: " . ($this->fecha_requerimiento ?? 'N/A') . "\n";
        $descripcion .= "👤 Solicitante: " . ($this->solicitante ?? 'N/A') . "\n";
        $descripcion .= "📍 Área: " . ($area->nombre ?? $this->area ?? 'N/A') . "\n";
        $descripcion .= "📊 Estatus: " . ($this->estatus ?? 'Pendiente') . "\n";
        $descripcion .= "========================================\n\n";
        
        // Agregar artículos
        $articulos = $this->articulos;
        if ($articulos->count() > 0) {
            $descripcion .= "📦 ARTÍCULOS SOLICITADOS:\n";
            foreach ($articulos as $index => $articulo) {
                $descripcion .= ($index + 1) . ". " . ($articulo->descripcion ?? 'Sin descripción');
                if ($articulo->cantidad) {
                    $descripcion .= " - Cantidad: " . $articulo->cantidad;
                }
                if ($articulo->unidad_medida) {
                    $descripcion .= " " . $articulo->unidad_medida;
                }
                $descripcion .= "\n";
            }
            $descripcion .= "\n";
        }
        
        $descripcion .= "⚡ ACCIÓN REQUERIDA:\n";
        $descripcion .= "1. Revisar la requisición y los artículos solicitados\n";
        $descripcion .= "2. Verificar disponibilidad de presupuesto\n";
        $descripcion .= "3. Aprobar o rechazar la requisición";
        
        return $descripcion;
    }

    protected function generarDescripcionOrdenCompra()
    {
        $proyecto = $this->proyecto;
        
        $descripcion = "📋 REQUISICIÓN COTIZADA - PROCEDER CON ORDEN DE COMPRA\n\n";
        $descripcion .= "========================================\n";
        $descripcion .= "📌 Folio Requisición: " . ($this->folio ?? 'N/A') . "\n";
        $descripcion .= "🏗️ Proyecto: " . ($proyecto->nombre ?? 'N/A') . "\n";
        $descripcion .= "📅 Fecha: " . ($this->fecha_requerimiento ?? date('Y-m-d')) . "\n";
        $descripcion .= "👤 Solicitante: " . ($this->solicitante ?? 'N/A') . "\n";
        $descripcion .= "📍 Área: " . ($this->area ?? 'N/A') . "\n";
        $descripcion .= "========================================\n\n";
        
        $articulos = $this->articulos;
        if ($articulos->count() > 0) {
            $descripcion .= "📦 ARTÍCULOS COTIZADOS:\n\n";
            foreach ($articulos as $articulo) {
                $cotizacion = $articulo->cotizacionSeleccionada();
                $descripcion .= "• " . ($articulo->descripcion ?? 'Sin descripción');
                if ($articulo->cantidad) {
                    $descripcion .= " - Cantidad: " . $articulo->cantidad;
                }
                if ($cotizacion) {
                    $descripcion .= " - Precio: $" . number_format($cotizacion->precio_unitario ?? 0, 2);
                    $descripcion .= " - Proveedor: " . ($cotizacion->proveedor->nombre ?? 'N/A');
                }
                $descripcion .= "\n";
            }
            $descripcion .= "\n";
        }
        
        $descripcion .= "⚡ ACCIÓN REQUERIDA:\n";
        $descripcion .= "1. Revisar las cotizaciones seleccionadas para cada artículo\n";
        $descripcion .= "2. Generar la Orden de Compra con los proveedores seleccionados\n";
        $descripcion .= "3. Enviar la Orden de Compra para aprobación\n";
        $descripcion .= "4. Dar seguimiento a la entrega de materiales";
        
        return $descripcion;
    }

    // ========== MÉTODOS DE BITÁCORA ==========
    
    /**
     * Registra una entrada en la bitácora
     */
    protected function registrarEnBitacora($titulo, $descripcion)
    {
        if (!$this->proyecto_id) {
            return;
        }

        try {
            // Verificar si existe el modelo BitacoraEntry
            if (class_exists(\App\Models\BitacoraEntry::class)) {
                \App\Models\BitacoraEntry::create([
                    'proyecto_id' => $this->proyecto_id,
                    'tipo' => 'tarea_automatica',
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'fecha' => now()->toDateString(),
                    'hora' => now()->toTimeString(),
                    'responsable' => auth()->user()->name ?? 'Sistema',
                    'estado' => 'pendiente',
                    'created_by' => auth()->id() ?? 1,
                ]);
            }
        } catch (\Exception $e) {
            Log::warning("No se pudo registrar en bitácora: " . $e->getMessage());
        }
    }

    // ========== MÉTODOS DE ACTUALIZACIÓN DE ESTATUS ==========
    
    public function actualizarEstatusCotizacion()
    {
        $totalArticulos = $this->articulos->count();
        $cotizados = $this->articulos->where('cotizada', true)->count();
        
        if ($totalArticulos == 0) {
            $this->estatus_cotizacion = 'Pendiente';
        } elseif ($cotizados == 0) {
            $this->estatus_cotizacion = 'Pendiente';
        } elseif ($cotizados < $totalArticulos) {
            $this->estatus_cotizacion = 'En_Cotizacion';
        } elseif ($cotizados == $totalArticulos) {
            $this->estatus_cotizacion = 'En_Cotizacion';
        }
        
        $this->save();
        
        // Si todos los artículos están cotizados, generar tarea de OC
        if ($this->estatus_cotizacion === 'En_Cotizacion' && $cotizados == $totalArticulos) {
            $this->generarTareaOrdenCompra();
        }
        
        return $this->estatus_cotizacion;
    }
    
    public function autorizarCotizaciones()
    {
        $todosSeleccionados = $this->articulos->every(function($articulo) {
            return $articulo->tieneCotizacionSeleccionada();
        });
        
        if ($todosSeleccionados) {
            $this->estatus_cotizacion = 'Cotizada';
            $this->save();
            
            $this->generarTareaOrdenCompra();
            
            return true;
        }
        
        return false;
    }

    // ========== MÉTODOS DE VERIFICACIÓN ==========
    
    public function todosArticulosCotizados()
    {
        return $this->articulos->where('cotizada', false)->count() == 0;
    }
    
    public function tieneCotizaciones()
    {
        return $this->articulos->contains(function($articulo) {
            return $articulo->tieneCotizacion();
        });
    }
    
    public function tieneTodasCotizacionesSeleccionadas()
    {
        return $this->articulos->every(function($articulo) {
            return $articulo->tieneCotizacionSeleccionada();
        });
    }
    
    public function getResumenCotizacionesAttribute()
    {
        $total = $this->articulos->count();
        $cotizadas = $this->articulos->where('cotizada', true)->count();
        
        return [
            'total_articulos' => $total,
            'cotizados' => $cotizadas,
            'pendientes' => $total - $cotizadas,
            'porcentaje' => $total > 0 ? round(($cotizadas / $total) * 100, 2) : 0
        ];
    }

    public function tareaAsociada()
{
    return $this->morphOne(WorkflowTask::class, 'taskable')
        ->where('module', 'requisiciones');
}
}