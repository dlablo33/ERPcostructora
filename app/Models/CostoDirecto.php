<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class CostoDirecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'costos_directos';

    protected $fillable = [
        'proyecto_id',
        'proveedor_id',
        'empleado_id',
        'categoria',
        'concepto',
        'fecha',
        'proveedor_nombre',
        'rfc',
        'factura',
        'descripcion',
        'unidad',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'iva',
        'total',
        'fecha_pago',
        'estatus_pago',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'cantidad' => 'decimal:4',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha' => 'date',
        'fecha_pago' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'categoria_nombre',
        'estatus_nombre',
        'estatus_badge',
        'subtotal_formateado',
        'iva_formateado',
        'total_formateado',
        'precio_unitario_formateado'
    ];

    // ==================== CATÁLOGOS ====================

    const CATEGORIAS = [
        'materiales' => 'Materiales',
        'mano_obra' => 'Mano de Obra',
        'maquinaria' => 'Maquinaria',
        'subcontratos' => 'Subcontratos',
        'equipos' => 'Equipos'
    ];

    const CATEGORIAS_ICONOS = [
        'materiales' => 'fa-box',
        'mano_obra' => 'fa-users',
        'maquinaria' => 'fa-tractor',
        'subcontratos' => 'fa-handshake',
        'equipos' => 'fa-tools'
    ];

    const CATEGORIAS_COLORES = [
        'materiales' => '#0d6efd',
        'mano_obra' => '#28a745',
        'maquinaria' => '#ffc107',
        'subcontratos' => '#dc3545',
        'equipos' => '#6c757d'
    ];

    const ESTADOS_PAGO = [
        'pagado' => 'Pagado',
        'pendiente' => 'Pendiente',
        'programado' => 'Programado',
        'vencido' => 'Vencido'
    ];

    const ESTADOS_BADGE = [
        'pagado' => 'badge-pagado',
        'pendiente' => 'badge-pendiente',
        'programado' => 'badge-programado',
        'vencido' => 'badge-vencido'
    ];

    const ESTADOS_COLORES = [
        'pagado' => '#28a745',
        'pendiente' => '#ffc107',
        'programado' => '#17a2b8',
        'vencido' => '#dc3545'
    ];

    // ==================== RELACIONES ====================

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function documentos()
    {
        return $this->hasMany(CostoDirectoDocumento::class, 'costo_directo_id');
    }

    // ==================== ACCESSORS ====================

    public function getCategoriaNombreAttribute(): string
    {
        return self::CATEGORIAS[$this->categoria] ?? $this->categoria;
    }

    public function getCategoriaIconoAttribute(): string
    {
        return self::CATEGORIAS_ICONOS[$this->categoria] ?? 'fa-tag';
    }

    public function getCategoriaColorAttribute(): string
    {
        return self::CATEGORIAS_COLORES[$this->categoria] ?? '#6c757d';
    }

    public function getEstatusNombreAttribute(): string
    {
        return self::ESTADOS_PAGO[$this->estatus_pago] ?? $this->estatus_pago;
    }

    public function getEstatusBadgeAttribute(): string
    {
        return self::ESTADOS_BADGE[$this->estatus_pago] ?? 'badge-pendiente';
    }

    public function getEstatusColorAttribute(): string
    {
        return self::ESTADOS_COLORES[$this->estatus_pago] ?? '#6c757d';
    }

    public function getSubtotalFormateadoAttribute(): string
    {
        return '$' . number_format($this->subtotal, 2);
    }

    public function getIvaFormateadoAttribute(): string
    {
        return '$' . number_format($this->iva, 2);
    }

    public function getTotalFormateadoAttribute(): string
    {
        return '$' . number_format($this->total, 2);
    }

    public function getPrecioUnitarioFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_unitario, 2);
    }

    public function getNombreProveedorAttribute(): string
    {
        if ($this->proveedor) {
            return $this->proveedor->nombre;
        }
        return $this->proveedor_nombre ?? '-';
    }

    public function getNombreEmpleadoAttribute(): string
    {
        if ($this->empleado) {
            return trim($this->empleado->nombre . ' ' . ($this->empleado->apellido_paterno ?? ''));
        }
        return '-';
    }

    public function getEstaVencidoAttribute(): bool
    {
        if ($this->estatus_pago !== 'vencido' && $this->fecha_pago) {
            return Carbon::parse($this->fecha_pago)->isPast();
        }
        return $this->estatus_pago === 'vencido';
    }

    // ==================== MUTATORS ====================

    public function setCantidadAttribute($value)
    {
        $this->attributes['cantidad'] = $value ?? 1;
        $this->recalcularTotales();
    }

    public function setPrecioUnitarioAttribute($value)
    {
        $this->attributes['precio_unitario'] = $value ?? 0;
        $this->recalcularTotales();
    }

    public function setSubtotalAttribute($value)
    {
        // Este campo se calcula automáticamente, no se debe asignar manualmente
        // pero lo permitimos por si viene del frontend
        $this->attributes['subtotal'] = $value ?? 0;
    }

    public function setIvaAttribute($value)
    {
        $this->attributes['iva'] = $value ?? 0;
        $this->recalcularTotales();
    }

    private function recalcularTotales(): void
    {
        $cantidad = $this->attributes['cantidad'] ?? 1;
        $precioUnitario = $this->attributes['precio_unitario'] ?? 0;
        $iva = $this->attributes['iva'] ?? 0;
        
        $subtotal = $cantidad * $precioUnitario;
        $this->attributes['subtotal'] = $subtotal;
        $this->attributes['total'] = $subtotal + $iva;
    }

    // ==================== SCOPES ====================

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopeByCategoria($query, $categoria)
    {
        if ($categoria && $categoria !== 'todos') {
            return $query->where('categoria', $categoria);
        }
        return $query;
    }

    public function scopeByEstatusPago($query, $estatus)
    {
        if ($estatus) {
            return $query->where('estatus_pago', $estatus);
        }
        return $query;
    }

    public function scopeByRangoFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('concepto', 'LIKE', "%{$termino}%")
                  ->orWhere('proveedor_nombre', 'LIKE', "%{$termino}%")
                  ->orWhere('factura', 'LIKE', "%{$termino}%")
                  ->orWhere('rfc', 'LIKE', "%{$termino}%")
                  ->orWhereHas('proyecto', function($sub) use ($termino) {
                      $sub->where('nombre', 'LIKE', "%{$termino}%")
                          ->orWhere('codigo', 'LIKE', "%{$termino}%");
                  });
            });
        }
        return $query;
    }

    public function scopePagados($query)
    {
        return $query->where('estatus_pago', 'pagado');
    }

    public function scopePendientes($query)
    {
        return $query->where('estatus_pago', 'pendiente');
    }

    public function scopeProgramados($query)
    {
        return $query->where('estatus_pago', 'programado');
    }

    public function scopeVencidos($query)
    {
        return $query->where('estatus_pago', 'vencido');
    }

    // ==================== MÉTODOS DE NEGOCIO ====================

    public function esPagado(): bool
    {
        return $this->estatus_pago === 'pagado';
    }

    public function esPendiente(): bool
    {
        return $this->estatus_pago === 'pendiente';
    }

    public function esProgramado(): bool
    {
        return $this->estatus_pago === 'programado';
    }

    public function esVencido(): bool
    {
        return $this->estatus_pago === 'vencido' || ($this->fecha_pago && Carbon::parse($this->fecha_pago)->isPast() && $this->estatus_pago !== 'pagado');
    }

    public function cambiarEstatusPago(string $nuevoEstatus): bool
    {
        if (!array_key_exists($nuevoEstatus, self::ESTADOS_PAGO)) {
            return false;
        }
        
        $this->estatus_pago = $nuevoEstatus;
        
        // Si se marca como pagado, registrar fecha de pago si no tiene
        if ($nuevoEstatus === 'pagado' && !$this->fecha_pago) {
            $this->fecha_pago = now();
        }
        
        return $this->save();
    }

    public function actualizarTotales(): bool
    {
        $this->recalcularTotales();
        return $this->save();
    }

    public function getResumen(): array
    {
        return [
            'id' => $this->id,
            'concepto' => $this->concepto,
            'categoria' => $this->categoria_nombre,
            'total' => $this->total,
            'estatus' => $this->estatus_nombre,
            'fecha' => $this->fecha?->format('d/m/Y'),
            'proyecto' => $this->proyecto?->nombre
        ];
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($costo) {
            // Establecer created_by si no está definido
            if (!$costo->created_by) {
                $costo->created_by = auth()->id();
            }
            
            // Recalcular totales antes de crear
            $costo->recalcularTotales();
            
            // Si proveedor_id está presente, copiar nombre
            if ($costo->proveedor_id && !$costo->proveedor_nombre) {
                $proveedor = Proveedor::find($costo->proveedor_id);
                if ($proveedor) {
                    $costo->proveedor_nombre = $proveedor->nombre;
                }
            }
        });

        static::updating(function ($costo) {
            // Recalcular totales antes de actualizar
            $costo->recalcularTotales();
        });

        static::saving(function ($costo) {
            // Recalcular totales siempre
            $costo->recalcularTotales();
        });

        static::saved(function ($costo) {
            // Actualizar costo acumulado en el proyecto
            if ($costo->proyecto_id) {
                $totalCostos = self::where('proyecto_id', $costo->proyecto_id)->sum('total');
                $costo->proyecto->update(['costo_directo_acumulado' => $totalCostos]);
            }
        });

        static::deleted(function ($costo) {
            // Actualizar costo acumulado en el proyecto al eliminar
            if ($costo->proyecto_id) {
                $totalCostos = self::where('proyecto_id', $costo->proyecto_id)->sum('total');
                $costo->proyecto->update(['costo_directo_acumulado' => $totalCostos]);
            }
        });
    }
}