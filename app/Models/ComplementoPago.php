<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\CFDI;

class ComplementoPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'complementos_pago';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'cliente_id',
        'rfc',
        'fecha_pago',
        'documento_relacionado',
        'forma_pago',
        'monto',
        'estatus',
        'uuid',
        'cfdi_id',
        'poliza_contable_id',
        'pago_id',
        'contrarecibo_id',
        'created_by'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación con el cliente (contacto)
     */
    public function cliente()
    {
        return $this->belongsTo(Contacto::class, 'cliente_id', 'contacto_id');
    }

    /**
     * Relación con el CFDI timbrado
     */
    public function cfdi()
    {
        return $this->belongsTo(Cfdi::class, 'cfdi_id', 'cfdi_id');
    }

    /**
     * Relación con la póliza contable
     */
    public function polizaContable()
    {
        return $this->belongsTo(PolizaContable::class, 'poliza_contable_id', 'poliza_contable_id');
    }

    /**
     * Relación con el pago (si viene de pagos)
     */
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id', 'id');
    }

    /**
     * Relación con el contrarecibo (si viene de contrarecibos)
     */
    public function contrarecibo()
    {
        return $this->belongsTo(Contrarecibo::class, 'contrarecibo_id', 'contrarecibo_id');
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
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    /**
     * Scope para filtrar por estatus
     */
    public function scopePorEstatus($query, $estatus)
    {
        if ($estatus) {
            return $query->where('estatus', $estatus);
        }
        return $query;
    }

    /**
     * Scope para filtrar por cliente
     */
    public function scopePorCliente($query, $clienteId)
    {
        if ($clienteId) {
            return $query->where('cliente_id', $clienteId);
        }
        return $query;
    }

    /**
     * Scope para filtrar complementos pendientes de timbrar
     */
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }

    /**
     * Scope para filtrar complementos timbrados
     */
    public function scopeTimbrados($query)
    {
        return $query->where('estatus', 'Timbrado');
    }

    /**
     * Scope para filtrar complementos cancelados
     */
    public function scopeCancelados($query)
    {
        return $query->where('estatus', 'Cancelado');
    }

    /**
     * Scope para búsqueda general
     */
    public function scopeBuscar($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('folio', 'LIKE', "%{$search}%")
                  ->orWhere('rfc', 'LIKE', "%{$search}%")
                  ->orWhere('documento_relacionado', 'LIKE', "%{$search}%")
                  ->orWhere('uuid', 'LIKE', "%{$search}%")
                  ->orWhereHas('cliente', function($sq) use ($search) {
                      $sq->where('razon_social', 'LIKE', "%{$search}%");
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
     * Obtener fecha de pago formateada
     */
    public function getFechaPagoFormateadaAttribute()
    {
        return $this->fecha_pago ? $this->fecha_pago->format('d/m/Y') : '-';
    }

    /**
     * Obtener fecha de pago para lista (día/mes abreviado/año)
     */
    public function getFechaListaAttribute()
    {
        if (!$this->fecha_pago) return '-';
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return $this->fecha_pago->format('d') . ' ' . $meses[$this->fecha_pago->month - 1] . ' ' . $this->fecha_pago->format('Y');
    }

    /**
     * Obtener nombre del cliente
     */
    public function getClienteNombreAttribute()
    {
        return $this->cliente ? $this->cliente->razon_social : '-';
    }

    /**
     * Obtener clase CSS para el badge del estatus
     */
    public function getBadgeClassAttribute()
    {
        return match($this->estatus) {
            'Timbrado' => 'badge-timbrado',
            'Cancelado' => 'badge-cancelado',
            default => 'badge-pendiente'
        };
    }

    /**
     * Verificar si está pendiente de timbrar
     */
    public function isPendiente()
    {
        return $this->estatus === 'Pendiente';
    }

    /**
     * Verificar si está timbrado
     */
    public function isTimbrado()
    {
        return $this->estatus === 'Timbrado';
    }

    /**
     * Verificar si está cancelado
     */
    public function isCancelado()
    {
        return $this->estatus === 'Cancelado';
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
     * Setear RFC en mayúsculas
     */
    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = $value ? strtoupper($value) : null;
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
        
        if ($ultimo && preg_match('/CP-' . $year . '-(\d+)/', $ultimo->folio, $matches)) {
            $numero = intval($matches[1]) + 1;
        } else {
            $numero = 1;
        }
        
        return 'CP-' . $year . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Cambiar estatus del complemento
     */
    public function cambiarEstatus($nuevoEstatus)
    {
        $estatusValidos = ['Pendiente', 'Timbrado', 'Cancelado'];
        
        if (!in_array($nuevoEstatus, $estatusValidos)) {
            throw new \InvalidArgumentException("Estatus no válido: {$nuevoEstatus}");
        }
        
        $this->estatus = $nuevoEstatus;
        return $this->save();
    }

    /**
     * Asignar UUID después de timbrar
     */
    public function asignarUuid($uuid, $cfdiId = null)
    {
        $this->uuid = $uuid;
        $this->cfdi_id = $cfdiId;
        $this->estatus = 'Timbrado';
        return $this->save();
    }

    /**
     * Cancelar el complemento
     */
    public function cancelar()
    {
        $this->estatus = 'Cancelado';
        return $this->save();
    }
}