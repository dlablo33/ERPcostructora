<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Facturacion\Contacto;

class Contrato extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contratos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_contrato',
        'proyecto_id',
        'cliente_id',
        'proveedor_id',
        'fecha_firma',
        'fecha_inicio',
        'fecha_fin',
        'monto_total',
        'anticipo_porcentaje',
        'anticipo_monto',
        'saldo_restante',
        'estado',
        'version',
        'descripcion',
        'forma_pago',
        'plazo_pago',
        'penalizaciones',
        'garantias',
        'responsable_contratante',
        'cargo_contratante',
        'email_contratante',
        'rfc_cliente',
        'responsable_contratista',
        'cargo_contratista',
        'email_contratista',
        'documento_path',
        'documento_nombre',
        'documento_tamanio',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_firma' => 'date',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto_total' => 'decimal:2',
        'anticipo_porcentaje' => 'decimal:2',
        'anticipo_monto' => 'decimal:2',
        'saldo_restante' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the project that owns the contract.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Get the client (contact) for the contract.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Contacto::class, 'cliente_id', 'contacto_id');
    }

    /**
     * Get the provider (supplier) for the contract.
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Get the user who created the contract.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the contract.
     */
    public function actualizador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the versions for the contract.
     */
    public function versiones(): HasMany
    {
        return $this->hasMany(DocumentoVersion::class, 'documento_id')
            ->where('documento_tipo', 'contrato');
    }

    /**
     * Get the current version of the contract.
     */
    public function versionActual()
    {
        return $this->hasOne(DocumentoVersion::class, 'documento_id')
            ->where('documento_tipo', 'contrato')
            ->where('es_actual', true);
    }

    /**
     * Scope a query to only include active contracts.
     */
    public function scopeVigentes($query)
    {
        return $query->where('estado', 'Vigente');
    }

    /**
     * Scope a query to only include contracts in review.
     */
    public function scopeEnRevision($query)
    {
        return $query->where('estado', 'En Revisión');
    }

    /**
     * Scope a query to only include expired contracts.
     */
    public function scopeVencidos($query)
    {
        return $query->where('estado', 'Vencido');
    }

    /**
     * Scope a query to filter by project.
     */
    public function scopePorProyecto($query, $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Get the formatted total amount.
     */
    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto_total, 2);
    }

    /**
     * Get the formatted anticipo amount.
     */
    public function getAnticipoFormateadoAttribute(): string
    {
        return '$' . number_format($this->anticipo_monto, 2);
    }

    /**
     * Get the formatted saldo amount.
     */
    public function getSaldoFormateadoAttribute(): string
    {
        return '$' . number_format($this->saldo_restante, 2);
    }

    /**
     * Get the status badge class.
     */
    public function getEstadoBadgeClassAttribute(): string
    {
        return match ($this->estado) {
            'Vigente' => 'badge-success',
            'En Revisión' => 'badge-warning',
            'Vencido' => 'badge-secondary',
            default => 'badge-secondary',
        };
    }

    /**
     * Get the days remaining until contract ends.
     */
    public function getDiasRestantesAttribute(): int
    {
        if (!$this->fecha_fin) {
            return 0;
        }
        $diff = now()->diffInDays($this->fecha_fin, false);
        return max($diff, 0);
    }

    /**
     * Check if contract is active.
     */
    public function isVigente(): bool
    {
        return $this->estado === 'Vigente';
    }

    /**
     * Check if contract is expired.
     */
    public function isVencido(): bool
    {
        return $this->estado === 'Vencido' || ($this->fecha_fin && $this->fecha_fin < now());
    }

    /**
     * Get the contract number with prefix.
     */
    public function getNumeroContratoAttribute(): string
    {
        return $this->no_contrato ?? 'N/A';
    }

    /**
     * Generate the next contract number.
     */
    public static function generarSiguienteNumero(): string
    {
        $year = now()->format('Y');
        $last = self::whereYear('created_at', $year)->count();
        $numero = str_pad($last + 1, 3, '0', STR_PAD_LEFT);
        return "CON-{$year}-{$numero}";
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_contrato)) {
                $model->no_contrato = self::generarSiguienteNumero();
            }
            
            if ($model->fecha_firma && $model->fecha_inicio && $model->fecha_fin) {
                $model->saldo_restante = $model->monto_total - $model->anticipo_monto;
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('monto_total') || $model->isDirty('anticipo_monto')) {
                $model->saldo_restante = $model->monto_total - $model->anticipo_monto;
            }
        });
    }
}