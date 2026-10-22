<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anticipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anticipos';

    protected $fillable = [
        'folio',
        'proveedor_id',
        'cuenta_bancaria_id',
        'moneda_id',
        'user_id',
        'forma_pago',
        'fecha',
        'referencia',
        'referencia_bancaria',
        'monto',
        'monto_restante',
        'tipo_cambio',
        'descripcion',
        'estatus',
    ];

    protected $casts = [
        'fecha'          => 'date',
        'monto'          => 'decimal:2',
        'monto_restante' => 'decimal:2',
        'tipo_cambio'    => 'decimal:4',
    ];

    protected $attributes = [
        'estatus'     => 'Pendiente',
        'tipo_cambio' => 1,
    ];

    // ==========================================
    // RELACIONES
    // ==========================================

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class, 'cuenta_bancaria_id');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aplicaciones()
    {
        return $this->hasMany(AplicacionAnticipo::class, 'anticipo_id');
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }

    public function scopeAprobados($query)
    {
        return $query->where('estatus', 'Aprobado');
    }

    public function scopeLiquidados($query)
    {
        return $query->where('estatus', 'Liquidado');
    }

    public function scopePorRangoFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha', [$inicio, $fin]);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function ($q) use ($termino) {
            $q->where('folio', 'LIKE', "%{$termino}%")
              ->orWhere('referencia', 'LIKE', "%{$termino}%")
              ->orWhere('referencia_bancaria', 'LIKE', "%{$termino}%")
              ->orWhere('descripcion', 'LIKE', "%{$termino}%")
              ->orWhereHas('proveedor', function ($pq) use ($termino) {
                  $pq->where('nombre', 'LIKE', "%{$termino}%")
                     ->orWhere('alias', 'LIKE', "%{$termino}%")
                     ->orWhere('razon_social', 'LIKE', "%{$termino}%");
              });
        });
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    public function getMontoAplicadoAttribute(): float
    {
        return (float) $this->aplicaciones()->sum('monto');
    }

    public function getPuedeLiquidarseAttribute(): bool
    {
        return in_array($this->estatus, ['Pendiente', 'Aprobado'])
            && $this->monto_restante > 0;
    }

    public function getEstaLiquidadoAttribute(): bool
    {
        return $this->estatus === 'Liquidado' || $this->monto_restante <= 0;
    }

    public function getCuentaBancariaNumeroAttribute(): string
    {
        if (!$this->cuentaBancaria) {
            return '-';
        }

        return $this->cuentaBancaria->numero_formateado
            ?? $this->cuentaBancaria->numero_cuenta
            ?? '-';
    }

    // ==========================================
    // EVENTOS
    // ==========================================

    protected static function booted(): void
    {
        static::creating(function ($anticipo) {
            if (empty($anticipo->monto_restante)) {
                $anticipo->monto_restante = $anticipo->monto;
            }
            if (empty($anticipo->folio)) {
                $anticipo->folio = self::generarFolio();
            }
        });

        static::updating(function ($anticipo) {
            if ($anticipo->monto_restante <= 0
                && $anticipo->estatus === 'Aprobado') {
                $anticipo->estatus = 'Liquidado';
            }
        });
    }

    public static function generarFolio(): string
    {
        $anio   = now()->format('Y');
        $ultimo = self::withTrashed()
            ->whereYear('created_at', $anio)
            ->where('folio', 'LIKE', "ANT-{$anio}-%")
            ->orderBy('id', 'desc')
            ->first();

        $consecutivo = $ultimo ? ((int) substr($ultimo->folio, -4)) + 1 : 1;

        return sprintf('ANT-%s-%04d', $anio, $consecutivo);
    }
}