<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class CostoIndirecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'costos_indirectos';

    protected $fillable = [
        'proyecto_id',
        'proveedor_id',
        'categoria',
        'concepto',
        'fecha',
        'proveedor_nombre',
        'rfc',
        'factura',
        'descripcion',
        'subtotal',
        'iva',
        'total',
        'forma_pago',
        'fecha_pago',
        'estatus_pago',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
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
        'categoria_icono',
        'categoria_color',
        'estatus_nombre',
        'estatus_badge',
        'estatus_color',
        'subtotal_formateado',
        'iva_formateado',
        'total_formateado',
        'forma_pago_nombre'
    ];

    // ==================== CATÁLOGOS ====================

    const CATEGORIAS = [
        'personal_tecnico' => 'Personal Técnico',
        'administracion' => 'Administración de Obra',
        'seguridad' => 'Seguridad e Higiene',
        'servicios' => 'Servicios Generales',
        'herramienta' => 'Herramienta y Equipo'
    ];

    const CATEGORIAS_ICONOS = [
        'personal_tecnico' => 'fa-user-tie',
        'administracion' => 'fa-clipboard-list',
        'seguridad' => 'fa-hard-hat',
        'servicios' => 'fa-bolt',
        'herramienta' => 'fa-tools'
    ];

    const CATEGORIAS_COLORES = [
        'personal_tecnico' => '#0d6efd',
        'administracion' => '#28a745',
        'seguridad' => '#ffc107',
        'servicios' => '#17a2b8',
        'herramienta' => '#6c757d'
    ];

    const FORMAS_PAGO = [
        'transferencia' => 'Transferencia',
        'cheque' => 'Cheque',
        'efectivo' => 'Efectivo',
        'tarjeta' => 'Tarjeta'
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

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function documentos()
    {
        return $this->hasMany(CostoIndirectoDocumento::class, 'costo_indirecto_id');
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

    public function getFormaPagoNombreAttribute(): string
    {
        return self::FORMAS_PAGO[$this->forma_pago] ?? $this->forma_pago;
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

    public function getNombreProveedorAttribute(): string
    {
        if ($this->proveedor) {
            return $this->proveedor->nombre;
        }
        return $this->proveedor_nombre ?? '-';
    }

    public function getEstaVencidoAttribute(): bool
    {
        if ($this->estatus_pago !== 'vencido' && $this->fecha_pago) {
            return Carbon::parse($this->fecha_pago)->isPast();
        }
        return $this->estatus_pago === 'vencido';
    }

    // ==================== MUTATORS ====================

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = $value ?? 0;
        $this->recalcularTotal();
    }

    public function setIvaAttribute($value)
    {
        $this->attributes['iva'] = $value ?? 0;
        $this->recalcularTotal();
    }

    private function recalcularTotal(): void
    {
        $subtotal = $this->attributes['subtotal'] ?? 0;
        $iva = $this->attributes['iva'] ?? 0;
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
        
        if ($nuevoEstatus === 'pagado' && !$this->fecha_pago) {
            $this->fecha_pago = now();
        }
        
        return $this->save();
    }

    public function actualizarTotales(): bool
    {
        $this->recalcularTotal();
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
            if (!$costo->created_by) {
                $costo->created_by = auth()->id();
            }
            
            $costo->recalcularTotal();
            
            if ($costo->proveedor_id && !$costo->proveedor_nombre) {
                $proveedor = Proveedor::find($costo->proveedor_id);
                if ($proveedor) {
                    $costo->proveedor_nombre = $proveedor->nombre;
                }
            }
        });

        static::updating(function ($costo) {
            $costo->recalcularTotal();
        });

        static::saving(function ($costo) {
            $costo->recalcularTotal();
        });

        static::saved(function ($costo) {
            if ($costo->proyecto_id) {
                $totalIndirectos = self::where('proyecto_id', $costo->proyecto_id)->sum('total');
                $totalDirectos = $costo->proyecto->costo_directo_acumulado ?? 0;
                
                $costo->proyecto->update([
                    'costo_indirecto_acumulado' => $totalIndirectos,
                    'costo_total_proyecto' => $totalDirectos + $totalIndirectos
                ]);
            }
        });

        static::deleted(function ($costo) {
            if ($costo->proyecto_id) {
                $totalIndirectos = self::where('proyecto_id', $costo->proyecto_id)->sum('total');
                $totalDirectos = $costo->proyecto->costo_directo_acumulado ?? 0;
                
                $costo->proyecto->update([
                    'costo_indirecto_acumulado' => $totalIndirectos,
                    'costo_total_proyecto' => $totalDirectos + $totalIndirectos
                ]);
            }
        });
    }
}