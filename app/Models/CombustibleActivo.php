<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CombustibleActivo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'combustible_activos';

    protected $fillable = [
        'activo_id',
        'proyecto_id',
        'operador_id',
        'created_by',
        'folio',
        'fecha',
        'litros',
        'costo',
        'precio_litro',
        'horometro',
        'factura',
        'proveedor',
        'observaciones'
    ];

    protected $casts = [
        'litros' => 'decimal:2',
        'costo' => 'decimal:2',
        'precio_litro' => 'decimal:2',
        'horometro' => 'decimal:2',
        'fecha' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'costo_formateado',
        'precio_formateado',
        'nombre_operador',
        'nombre_proyecto',
        'nombre_activo'
    ];

    // ==================== RELACIONES ====================

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function operador()
    {
        return $this->belongsTo(Plantilla::class, 'operador_id', 'plantilla_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==================== ACCESSORS ====================

    public function getCostoFormateadoAttribute(): string
    {
        return '$' . number_format($this->costo, 2);
    }

    public function getPrecioFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_litro, 2);
    }

    public function getNombreOperadorAttribute(): string
    {
        if (!$this->operador) {
            return 'No asignado';
        }
        return trim($this->operador->nombre . ' ' . 
                   ($this->operador->apellido_paterno ?? '') . ' ' . 
                   ($this->operador->apellido_materno ?? ''));
    }

    public function getNombreProyectoAttribute(): string
    {
        return $this->proyecto?->nombre ?? 'No asignado';
    }

    public function getNombreActivoAttribute(): string
    {
        return $this->activo?->nombre_completo ?? 'No asignado';
    }

    public function getRendimientoAttribute(): ?float
    {
        return $this->horometro && $this->litros > 0 ? $this->litros / $this->horometro : null;
    }

    // ==================== SCOPES ====================

    public function scopeByActivo($query, $activoId)
    {
        if ($activoId) {
            return $query->where('activo_id', $activoId);
        }
        return $query;
    }

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
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

    // ==================== MÉTODOS ====================

    public function getResumen(): array
    {
        return [
            'id' => $this->id,
            'folio' => $this->folio,
            'activo' => $this->nombre_activo,
            'fecha' => $this->fecha?->format('d/m/Y'),
            'litros' => $this->litros,
            'costo' => $this->costo,
            'operador' => $this->nombre_operador
        ];
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($combustible) {
            if (!$combustible->folio) {
                $fecha = now()->format('Ymd');
                $count = self::whereDate('created_at', now()->toDateString())->count() + 1;
                $combustible->folio = 'COM-' . $fecha . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
            
            if (!$combustible->created_by) {
                $combustible->created_by = auth()->id();
            }
            
            // Calcular precio_litro si no viene
            if (!$combustible->precio_litro && $combustible->litros > 0) {
                $combustible->precio_litro = $combustible->costo / $combustible->litros;
            }
        });
    }
}