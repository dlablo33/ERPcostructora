<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GastoProyecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gastos_proyecto';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'fecha',
        'proyecto_id',
        'categoria_id',
        'proveedor_id',
        'monto',
        'partida',
        'tipo_documento',
        'estatus',
        'avance',
        'notas',
        'poliza_contable_id',
        'created_by'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
        'avance' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // ============================================
    // RELACIONES
    // ============================================

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaGasto::class, 'categoria_id', 'id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id');
    }

    public function polizaContable()
    {
        return $this->belongsTo(PolizaContable::class, 'poliza_contable_id', 'poliza_contable_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopePorProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    public function scopePorEstatus($query, $estatus)
    {
        if ($estatus) {
            return $query->where('estatus', $estatus);
        }
        return $query;
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        if ($categoriaId) {
            return $query->where('categoria_id', $categoriaId);
        }
        return $query;
    }

    public function scopeAprobados($query)
    {
        return $query->where('estatus', 'Aprobado');
    }

    public function scopePendientes($query)
    {
        return $query->whereIn('estatus', ['Pendiente', 'En revisión']);
    }

    public function scopeRechazados($query)
    {
        return $query->where('estatus', 'Rechazado');
    }

    public function scopeBuscar($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('folio', 'LIKE', "%{$search}%")
                  ->orWhere('notas', 'LIKE', "%{$search}%")
                  ->orWhereHas('proyecto', function($sq) use ($search) {
                      $sq->where('nombre', 'LIKE', "%{$search}%")
                        ->orWhere('codigo', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('proveedor', function($sq) use ($search) {
                      $sq->where('nombre', 'LIKE', "%{$search}%");
                  });
            });
        }
        return $query;
    }

    // ============================================
    // ACCESORS
    // ============================================

    public function getMontoFormateadoAttribute()
    {
        return '$' . number_format($this->monto, 2);
    }

    public function getFechaFormateadaAttribute()
    {
        return $this->fecha ? $this->fecha->format('d/m/Y') : '-';
    }

    public function getFechaListaAttribute()
    {
        if (!$this->fecha) return '-';
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return $this->fecha->format('d') . ' ' . $meses[$this->fecha->month - 1] . ' ' . $this->fecha->format('Y');
    }

    public function getProyectoCodigoAttribute()
    {
        return $this->proyecto ? $this->proyecto->codigo : '-';
    }

    public function getProyectoNombreAttribute()
    {
        return $this->proyecto ? $this->proyecto->nombre : '-';
    }

    public function getCategoriaNombreAttribute()
    {
        return $this->categoria ? $this->categoria->nombre : '-';
    }

    public function getProveedorNombreAttribute()
    {
        return $this->proveedor ? $this->proveedor->nombre : 'No especificado';
    }

    public function getProyectoColorAttribute()
    {
        $colores = ['#C4540A', '#1A4F8C', '#1A6644', '#8C6A0A', '#6B1A8C', '#9C27B0', '#FF9800', '#00BCD4', '#4CAF50', '#E91E63'];
        $index = ($this->proyecto_id ?? 0) % count($colores);
        return $colores[$index];
    }

    public function getBadgeClassAttribute()
    {
        return match($this->estatus) {
            'Aprobado' => 'badge-aprobado',
            'Rechazado' => 'badge-rechazado',
            'En revisión' => 'badge-revision',
            default => 'badge-pendiente'
        };
    }

    public function getProgressClassAttribute()
    {
        if ($this->avance >= 90) return 'danger';
        if ($this->avance >= 70) return 'warn';
        return '';
    }

    // ============================================
    // MUTATORS
    // ============================================

    public function setFolioAttribute($value)
    {
        $this->attributes['folio'] = strtoupper($value);
    }

    public function setAvanceAttribute($value)
    {
        $this->attributes['avance'] = max(0, min(100, (int)$value));
    }

    // ============================================
    // MÉTODOS ADICIONALES
    // ============================================

    public static function generarFolio()
    {
        $year = date('Y');
        $ultimo = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($ultimo && preg_match('/FAC-' . $year . '-(\d+)/', $ultimo->folio, $matches)) {
            $numero = intval($matches[1]) + 1;
        } else {
            $numero = 1;
        }
        
        return 'FAC-' . $year . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    public function cambiarEstatus($nuevoEstatus)
    {
        $estatusValidos = ['Aprobado', 'Pendiente', 'Rechazado', 'En revisión'];
        
        if (!in_array($nuevoEstatus, $estatusValidos)) {
            throw new \InvalidArgumentException("Estatus no válido: {$nuevoEstatus}");
        }
        
        $this->estatus = $nuevoEstatus;
        return $this->save();
    }

    public function actualizarAvance($nuevoAvance)
    {
        $this->avance = max(0, min(100, (int)$nuevoAvance));
        return $this->save();
    }

    public function isAprobado()
    {
        return $this->estatus === 'Aprobado';
    }

    public function isPendiente()
    {
        return in_array($this->estatus, ['Pendiente', 'En revisión']);
    }

    public function isRechazado()
    {
        return $this->estatus === 'Rechazado';
    }
}