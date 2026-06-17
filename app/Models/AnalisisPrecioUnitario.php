<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class AnalisisPrecioUnitario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'analisis_precios_unitarios';

    protected $fillable = [
        'codigo',
        'concepto',
        'categoria',
        'unidad',
        'costo_materiales',
        'costo_mano_obra',
        'costo_maquinaria',
        'costo_subcontratos',
        'costo_total',
        'estado',
        'observaciones',
        'created_by'
    ];

    protected $casts = [
        'costo_materiales' => 'decimal:2',
        'costo_mano_obra' => 'decimal:2',
        'costo_maquinaria' => 'decimal:2',
        'costo_subcontratos' => 'decimal:2',
        'costo_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'categoria_nombre',
        'estado_nombre',
        'monto_formateado',
        'materiales_formateado',
        'mano_obra_formateado',
        'maquinaria_formateado',
        'subcontratos_formateado'
    ];

    // ==================== CATÁLOGOS DE ESTADOS ====================

    const CATEGORIAS = [
        'materiales' => 'Materiales',
        'mano_obra' => 'Mano de Obra',
        'maquinaria' => 'Maquinaria',
        'subcontratos' => 'Subcontratos',
        'indirectos' => 'Indirectos'
    ];

    const ESTADOS = [
        'activo' => 'Activo',
        'revision' => 'En Revisión',
        'inactivo' => 'Inactivo'
    ];

    const COLORES_ESTADO = [
        'activo' => '#28a745',
        'revision' => '#ffc107',
        'inactivo' => '#dc3545'
    ];

    const BADGES_ESTADO = [
        'activo' => 'badge-activo',
        'revision' => 'badge-revision',
        'inactivo' => 'badge-inactivo'
    ];

    const BADGES_CATEGORIA = [
        'materiales' => 'badge-materiales',
        'mano_obra' => 'badge-mano-obra',
        'maquinaria' => 'badge-maquinaria',
        'subcontratos' => 'badge-subcontratos',
        'indirectos' => 'badge-indirectos'
    ];

    // ==================== RELACIONES ====================

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function componentes()
    {
        return $this->hasMany(ApuComponente::class, 'apu_id');
    }

    // ==================== ACCESSORS ====================

    public function getCategoriaNombreAttribute(): string
    {
        return self::CATEGORIAS[$this->categoria] ?? $this->categoria;
    }

    public function getEstadoNombreAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->costo_total, 2);
    }

    public function getMaterialesFormateadoAttribute(): string
    {
        return $this->costo_materiales ? '$' . number_format($this->costo_materiales, 2) : '-';
    }

    public function getManoObraFormateadoAttribute(): string
    {
        return $this->costo_mano_obra ? '$' . number_format($this->costo_mano_obra, 2) : '-';
    }

    public function getMaquinariaFormateadoAttribute(): string
    {
        return $this->costo_maquinaria ? '$' . number_format($this->costo_maquinaria, 2) : '-';
    }

    public function getSubcontratosFormateadoAttribute(): string
    {
        return $this->costo_subcontratos ? '$' . number_format($this->costo_subcontratos, 2) : '-';
    }

    public function getBadgeCategoriaAttribute(): string
    {
        return self::BADGES_CATEGORIA[$this->categoria] ?? 'badge-categoria';
    }

    public function getBadgeEstadoAttribute(): string
    {
        return self::BADGES_ESTADO[$this->estado] ?? 'badge-estado';
    }

    public function getColorEstadoAttribute(): string
    {
        return self::COLORES_ESTADO[$this->estado] ?? '#6c757d';
    }

    // ==================== MUTATORS ====================

    public function setCostoMaterialesAttribute($value)
    {
        $this->attributes['costo_materiales'] = $value ?? 0;
        $this->recalcularTotal();
    }

    public function setCostoManoObraAttribute($value)
    {
        $this->attributes['costo_mano_obra'] = $value ?? 0;
        $this->recalcularTotal();
    }

    public function setCostoMaquinariaAttribute($value)
    {
        $this->attributes['costo_maquinaria'] = $value ?? 0;
        $this->recalcularTotal();
    }

    public function setCostoSubcontratosAttribute($value)
    {
        $this->attributes['costo_subcontratos'] = $value ?? 0;
        $this->recalcularTotal();
    }

    private function recalcularTotal(): void
    {
        $materiales = $this->attributes['costo_materiales'] ?? 0;
        $manoObra = $this->attributes['costo_mano_obra'] ?? 0;
        $maquinaria = $this->attributes['costo_maquinaria'] ?? 0;
        $subcontratos = $this->attributes['costo_subcontratos'] ?? 0;
        
        $this->attributes['costo_total'] = $materiales + $manoObra + $maquinaria + $subcontratos;
    }

    // ==================== SCOPES ====================

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeEnRevision($query)
    {
        return $query->where('estado', 'revision');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    public function scopeByCategoria($query, $categoria)
    {
        if ($categoria && $categoria !== 'todos') {
            return $query->where('categoria', $categoria);
        }
        return $query;
    }

    public function scopeByEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('codigo', 'LIKE', "%{$termino}%")
                  ->orWhere('concepto', 'LIKE', "%{$termino}%")
                  ->orWhere('categoria', 'LIKE', "%{$termino}%");
            });
        }
        return $query;
    }

    public function scopeByRangoCostos($query, $min, $max)
    {
        if ($min && $max) {
            return $query->whereBetween('costo_total', [$min, $max]);
        }
        return $query;
    }

    // ==================== MÉTODOS DE NEGOCIO ====================

    public function esActivo(): bool
    {
        return $this->estado === 'activo';
    }

    public function estaEnRevision(): bool
    {
        return $this->estado === 'revision';
    }

    public function esInactivo(): bool
    {
        return $this->estado === 'inactivo';
    }

    public function esMaterial(): bool
    {
        return $this->categoria === 'materiales';
    }

    public function esManoObra(): bool
    {
        return $this->categoria === 'mano_obra';
    }

    public function esMaquinaria(): bool
    {
        return $this->categoria === 'maquinaria';
    }

    public function esSubcontrato(): bool
    {
        return $this->categoria === 'subcontratos';
    }

    public function esIndirecto(): bool
    {
        return $this->categoria === 'indirectos';
    }

    public function cambiarEstado(string $nuevoEstado): bool
    {
        if (!array_key_exists($nuevoEstado, self::ESTADOS)) {
            return false;
        }
        
        $this->estado = $nuevoEstado;
        return $this->save();
    }

    public function duplicar(): self
    {
        $nuevo = $this->replicate();
        $nuevo->codigo = $this->generarNuevoCodigo();
        $nuevo->estado = 'revision';
        $nuevo->created_by = auth()->id();
        $nuevo->save();
        
        return $nuevo;
    }

    public function generarNuevoCodigo(): string
    {
        $prefijo = substr($this->codigo, 0, 3);
        $numero = intval(substr($this->codigo, 4)) + 1;
        
        // Buscar siguiente número disponible
        while (AnalisisPrecioUnitario::where('codigo', "{$prefijo}-" . str_pad($numero, 3, '0', STR_PAD_LEFT))->exists()) {
            $numero++;
        }
        
        return "{$prefijo}-" . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }

    // ==================== EVENTOS ====================

    protected static function booted()
    {
        static::creating(function ($apu) {
            // Si no tiene código, generarlo automáticamente
            if (!$apu->codigo) {
                $apu->codigo = $apu->generarNuevoCodigo();
            }
            
            // Establecer created_by si no está definido
            if (!$apu->created_by) {
                $apu->created_by = auth()->id();
            }
        });

        static::saving(function ($apu) {
            // Recalcular total antes de guardar
            $apu->recalcularTotal();
        });
    }
}