<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApuComponente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'apu_componentes';

    protected $fillable = [
        'apu_id',
        'tipo_componente',
        'material_id',
        'puesto_id',
        'maquinaria_id',
        'proveedor_id',
        'descripcion',
        'cantidad',
        'unidad',
        'costo_unitario',
        'costo_total',
        'orden',
        'observaciones'
    ];

    protected $casts = [
        'cantidad' => 'decimal:4',
        'costo_unitario' => 'decimal:2',
        'costo_total' => 'decimal:2',
        'orden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'tipo_nombre',
        'costo_formateado'
    ];

    // ==================== CATÁLOGOS ====================

    const TIPOS_COMPONENTE = [
        'material' => 'Material',
        'mano_obra' => 'Mano de Obra',
        'maquinaria' => 'Maquinaria',
        'subcontrato' => 'Subcontrato'
    ];

    // ==================== RELACIONES ====================

    public function apu()
    {
        return $this->belongsTo(AnalisisPrecioUnitario::class, 'apu_id');
    }

    public function material()
    {
        return $this->belongsTo(Articulo::class, 'material_id');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id');
    }

    public function maquinaria()
    {
        return $this->belongsTo(ActivoMaquinaria::class, 'maquinaria_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // ==================== ACCESSORS ====================

    public function getTipoNombreAttribute(): string
    {
        return self::TIPOS_COMPONENTE[$this->tipo_componente] ?? $this->tipo_componente;
    }

    public function getCostoFormateadoAttribute(): string
    {
        return '$' . number_format($this->costo_total, 2);
    }

    public function getNombreReferenciaAttribute(): string
    {
        switch ($this->tipo_componente) {
            case 'material':
                return $this->material?->nombre ?? $this->descripcion;
            case 'mano_obra':
                return $this->puesto?->nombre ?? $this->descripcion;
            case 'maquinaria':
                return $this->maquinaria?->nombre ?? $this->descripcion;
            case 'subcontrato':
                return $this->proveedor?->nombre ?? $this->descripcion;
            default:
                return $this->descripcion;
        }
    }

    // ==================== MUTATORS ====================

    public function setCantidadAttribute($value)
    {
        $this->attributes['cantidad'] = $value ?? 1;
        $this->recalcularTotal();
    }

    public function setCostoUnitarioAttribute($value)
    {
        $this->attributes['costo_unitario'] = $value ?? 0;
        $this->recalcularTotal();
    }

    private function recalcularTotal(): void
    {
        $cantidad = $this->attributes['cantidad'] ?? 1;
        $costoUnitario = $this->attributes['costo_unitario'] ?? 0;
        $this->attributes['costo_total'] = $cantidad * $costoUnitario;
    }

    // ==================== SCOPES ====================

    public function scopeByTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo_componente', $tipo);
        }
        return $query;
    }

    public function scopeByApu($query, $apuId)
    {
        return $query->where('apu_id', $apuId);
    }

    public function scopeMateriales($query)
    {
        return $query->where('tipo_componente', 'material');
    }

    public function scopeManoObra($query)
    {
        return $query->where('tipo_componente', 'mano_obra');
    }

    public function scopeMaquinaria($query)
    {
        return $query->where('tipo_componente', 'maquinaria');
    }

    public function scopeSubcontratos($query)
    {
        return $query->where('tipo_componente', 'subcontrato');
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::saving(function ($componente) {
            // Recalcular total antes de guardar
            $componente->recalcularTotal();
        });

        static::saved(function ($componente) {
            // Actualizar el costo total del APU padre
            if ($componente->apu) {
                $componente->apu->recalcularTotal();
                $componente->apu->save();
            }
        });

        static::deleted(function ($componente) {
            // Actualizar el costo total del APU padre al eliminar
            if ($componente->apu) {
                $componente->apu->recalcularTotal();
                $componente->apu->save();
            }
        });
    }
}