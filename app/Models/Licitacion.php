<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Facturacion\Contacto;  // <-- AGREGAR
use App\Models\Plantilla;          // <-- AGREGAR
use App\Models\User;                   // <-- AGREGAR
use App\Models\Proyecto; 

class Licitacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'licitaciones';

    protected $fillable = [
        'no_licitacion',
        'nombre',
        'descripcion',
        'cliente_id',
        'responsable_id',
        'created_by',
        'fecha_publicacion',
        'fecha_cierre',
        'monto_estimado',
        'moneda',
        'estado',
        'participa',
        'fecha_participacion',
        'fecha_adjudicacion',
        'proyecto_id',
        'documentos',
        'historial_movimientos',
        'observaciones'
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'fecha_cierre' => 'date',
        'fecha_participacion' => 'date',
        'fecha_adjudicacion' => 'date',
        'monto_estimado' => 'decimal:2',
        'participa' => 'boolean',
        'documentos' => 'array',
        'historial_movimientos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'dias_restantes',
        'monto_formateado',
        'nombre_responsable',
        'nombre_cliente'
    ];

    // ==================== RELACIONES ====================

    /**
     * Relación con el cliente/dependencia
     */
    public function cliente()
    {
        return $this->belongsTo(Contacto::class, 'cliente_id', 'contacto_id');
    }

    /**
     * Relación con el responsable (empleado)
     */
    public function responsable()
    {
        return $this->belongsTo(Plantilla::class, 'responsable_id', 'plantilla_id');
    }

    /**
     * Relación con el usuario que creó el registro
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con el proyecto (cuando se adjudica y convierte)
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    // ==================== ACCESSORS ====================

    /**
     * Calcula los días restantes hasta el cierre
     */
    public function getDiasRestantesAttribute(): int
    {
        if (!$this->fecha_cierre) {
            return 0;
        }

        $hoy = Carbon::now()->startOfDay();
        $cierre = Carbon::parse($this->fecha_cierre)->startOfDay();
        
        return $hoy->diffInDays($cierre, false);
    }

    /**
     * Formatea el monto con símbolo de moneda
     */
    public function getMontoFormateadoAttribute(): string
    {
        $simbolos = [
            'MXN' => '$',
            'USD' => 'US$',
            'EUR' => '€'
        ];
        
        $simbolo = $simbolos[$this->moneda] ?? '$';
        
        return $simbolo . number_format($this->monto_estimado, 2);
    }

    /**
     * Obtiene el nombre completo del responsable
     */
    public function getNombreResponsableAttribute(): string
    {
        if (!$this->responsable) {
            return 'No asignado';
        }
        
        return trim($this->responsable->nombre . ' ' . 
                   $this->responsable->apellido_paterno . ' ' . 
                   $this->responsable->apellido_materno);
    }

    /**
     * Obtiene el nombre del cliente/dependencia
     */
    public function getNombreClienteAttribute(): string
    {
        if (!$this->cliente) {
            return 'No especificado';
        }
        
        return $this->cliente->razon_social;
    }

    /**
     * Retorna la clase CSS para el badge del estado
     */
    public function getEstadoBadgeAttribute(): string
    {
        $badges = [
            'En Proceso' => 'badge-proceso',
            'Por Vencer' => 'badge-por-vencer',
            'Vencida' => 'badge-vencida',
            'Adjudicada' => 'badge-adjudicada',
            'No Adjudicada' => 'badge-no-adjudicada'
        ];
        
        return $badges[$this->estado] ?? 'badge-default';
    }

    // ==================== MUTATORS ====================

    /**
     * Asigna automáticamente el estado basado en fecha_cierre
     */
    public function setFechaCierreAttribute($value)
    {
        $this->attributes['fecha_cierre'] = $value;
        $this->actualizarEstadoAutomaticamente();
    }

    // ==================== SCOPES ====================

    /**
     * Scope para licitaciones activas (no vencidas ni adjudicadas)
     */
    public function scopeActivas($query)
    {
        return $query->whereIn('estado', ['En Proceso', 'Por Vencer']);
    }

    /**
     * Scope para licitaciones donde participamos
     */
    public function scopeParticipamos($query)
    {
        return $query->where('participa', true);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    /**
     * Scope para filtrar por rango de fechas de publicación
     */
    public function scopeByRangoFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha_publicacion', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    /**
     * Scope para búsqueda general
     */
    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('no_licitacion', 'LIKE', "%{$termino}%")
                  ->orWhere('nombre', 'LIKE', "%{$termino}%")
                  ->orWhereHas('cliente', function($subq) use ($termino) {
                      $subq->where('razon_social', 'LIKE', "%{$termino}%");
                  });
            });
        }
        return $query;
    }

    // ==================== MÉTODOS DE NEGOCIO ====================

    /**
     * Actualiza el estado automáticamente basado en fecha_cierre
     */
    public function actualizarEstadoAutomaticamente(): void
    {
        if (!$this->fecha_cierre) {
            return;
        }

        $hoy = Carbon::now()->startOfDay();
        $cierre = Carbon::parse($this->fecha_cierre)->startOfDay();
        $dias = $hoy->diffInDays($cierre, false);

        // Solo actualizar si está en proceso o por vencer
        if (in_array($this->estado, ['En Proceso', 'Por Vencer'])) {
            if ($dias < 0) {
                $this->attributes['estado'] = 'Vencida';
            } elseif ($dias <= 15) {
                $this->attributes['estado'] = 'Por Vencer';
            } else {
                $this->attributes['estado'] = 'En Proceso';
            }
        }
    }

    /**
     * Confirma participación en la licitación
     */
    public function confirmarParticipacion(): bool
    {
        if ($this->participa) {
            return false;
        }

        $this->participa = true;
        $this->fecha_participacion = Carbon::now();
        
        // Registrar en historial
        $this->agregarEventoHistorial(
            'Participación confirmada',
            'Se confirmó la participación en esta licitación'
        );
        
        return $this->save();
    }

    /**
     * Marca la licitación como adjudicada y la vincula a un proyecto
     */
    public function adjudicar($proyectoId): bool
    {
        if ($this->estado === 'Adjudicada') {
            return false;
        }

        $this->estado = 'Adjudicada';
        $this->fecha_adjudicacion = Carbon::now();
        $this->proyecto_id = $proyectoId;
        
        // Registrar en historial
        $this->agregarEventoHistorial(
            'Licitación adjudicada',
            "Se adjudicó la licitación y se vinculó al proyecto ID: {$proyectoId}"
        );
        
        return $this->save();
    }

    /**
     * Agrega un evento al historial de movimientos
     */
    public function agregarEventoHistorial(string $evento, string $detalles = null): void
    {
        $historial = $this->historial_movimientos ?? [];
        
        $historial[] = [
            'fecha' => Carbon::now()->toISOString(),
            'evento' => $evento,
            'usuario' => auth()->id() ?? 1,
            'nombre_usuario' => auth()->user()->name ?? 'Sistema',
            'detalles' => $detalles,
            'estado_anterior' => $this->getOriginal('estado'),
            'estado_nuevo' => $this->estado
        ];
        
        $this->historial_movimientos = $historial;
    }

    /**
     * Verifica si la licitación está próxima a vencer (15 días o menos)
     */
    public function estaPorVencer(): bool
    {
        $dias = $this->dias_restantes;
        return $dias > 0 && $dias <= 15;
    }

    /**
     * Verifica si la licitación ya venció
     */
    public function estaVencida(): bool
    {
        return $this->dias_restantes < 0;
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($licitacion) {
            // Asignar estado inicial basado en fecha_cierre
            $licitacion->actualizarEstadoAutomaticamente();
        });

        static::updating(function ($licitacion) {
            // Verificar si cambió la fecha_cierre para actualizar estado
            if ($licitacion->isDirty('fecha_cierre')) {
                $licitacion->actualizarEstadoAutomaticamente();
            }
        });
    }
}