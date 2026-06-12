<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GastoIndirecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gastos_indirectos';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'fecha',
        'proyecto_id',
        'proveedor_id',
        'monto',
        'partida',
        'tipo_documento',
        'forma_pago',
        'concepto',
        'tipo_gasto_id',
        'poliza_contable_id',
        'estatus',
        'created_by'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación con el proyecto (obra)
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    /**
     * Relación con el proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id');
    }

    /**
     * Relación con la póliza contable
     */
    public function polizaContable()
    {
        return $this->belongsTo(PolizaContable::class, 'poliza_contable_id', 'poliza_contable_id');
    }

    /**
     * Relación con el usuario que creó el registro
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // ============================================
    // SCOPES (Filtros)
    // ============================================

    /**
     * Scope para filtrar por proyecto
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    /**
     * Scope para filtrar por tipo de gasto (partida)
     */
    public function scopePorPartida($query, $partida)
    {
        if ($partida) {
            return $query->where('partida', $partida);
        }
        return $query;
    }

    /**
     * Scope para filtrar solo activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'activo');
    }

    /**
     * Scope para búsqueda general
     */
    public function scopeBuscar($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('folio', 'LIKE', "%{$search}%")
                  ->orWhere('concepto', 'LIKE', "%{$search}%")
                  ->orWhere('proveedor', 'LIKE', "%{$search}%")
                  ->orWhereHas('proyecto', function($sq) use ($search) {
                      $sq->where('nombre', 'LIKE', "%{$search}%")
                        ->orWhere('codigo', 'LIKE', "%{$search}%");
                  });
            });
        }
        return $query;
    }

    // ============================================
    // ACCESORS (Formateadores)
    // ============================================

    /**
     * Obtener monto formateado
     */
    public function getMontoFormateadoAttribute()
    {
        return '$' . number_format($this->monto, 2);
    }

    /**
     * Obtener fecha formateada
     */
    public function getFechaFormateadaAttribute()
    {
        return $this->fecha ? $this->fecha->format('d/m/Y') : '-';
    }

    /**
     * Obtener fecha formateada para listado (día/mes abreviado/año)
     */
    public function getFechaListaAttribute()
    {
        if (!$this->fecha) return '-';
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return $this->fecha->format('d') . ' ' . $meses[$this->fecha->month - 1] . ' ' . $this->fecha->format('Y');
    }

    /**
     * Obtener el código del proyecto
     */
    public function getProyectoCodigoAttribute()
    {
        return $this->proyecto ? $this->proyecto->codigo : '-';
    }

    /**
     * Obtener el nombre del proyecto
     */
    public function getProyectoNombreAttribute()
    {
        return $this->proyecto ? $this->proyecto->nombre : '-';
    }

    /**
     * Obtener el color del proyecto (para badges)
     */
    public function getProyectoColorAttribute()
    {
        $colores = [
            '#083CAE', '#1A4F8C', '#1A6644', '#8C6A0A', '#6B1A8C',
            '#9C27B0', '#FF9800', '#00BCD4', '#4CAF50', '#E91E63'
        ];
        $index = ($this->proyecto_id ?? 0) % count($colores);
        return $colores[$index];
    }

    /**
     * Obtener clase CSS para el badge del tipo de gasto
     */
    public function getBadgeClassAttribute()
    {
        $badges = [
            'Administrativo' => 'badge-administrativo',
            'Oficina' => 'badge-oficina',
            'Viaticos' => 'badge-viaticos',
            'Servicios' => 'badge-servicios',
            'Seguros' => 'badge-seguros',
            'Impuestos' => 'badge-impuestos'
        ];
        
        // Por ahora usamos la partida para determinar el badge
        $partidaMap = [
            'ADMIN01' => 'Administrativo',
            'VIA01' => 'Viaticos',
            'SER01' => 'Servicios',
            'SEG01' => 'Seguros',
            'IMP01' => 'Impuestos'
        ];
        
        $tipo = $partidaMap[$this->partida] ?? 'Administrativo';
        return $badges[$tipo] ?? 'badge-administrativo';
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Setear folio en mayúsculas
     */
    public function setFolioAttribute($value)
    {
        $this->attributes['folio'] = strtoupper($value);
    }

    /**
     * Setear concepto capitalizado
     */
    public function setConceptoAttribute($value)
    {
        $this->attributes['concepto'] = ucfirst(strtolower($value));
    }

    // ============================================
    // MÉTODOS ADICIONALES
    // ============================================

    /**
     * Generar folio automático
     */
    public static function generarFolio()
    {
        $year = date('Y');
        $ultimo = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($ultimo && preg_match('/GIN-' . $year . '-(\d+)/', $ultimo->folio, $matches)) {
            $numero = intval($matches[1]) + 1;
        } else {
            $numero = 1;
        }
        
        return 'GIN-' . $year . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Verificar si el gasto está activo
     */
    public function isActivo()
    {
        return $this->estatus === 'activo';
    }

    /**
     * Cancelar el gasto
     */
    public function cancelar()
    {
        $this->estatus = 'cancelado';
        return $this->save();
    }
}