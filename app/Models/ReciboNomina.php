<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Nomina;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ReciboNomina extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recibos_nomina';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Datos del recibo
        'folio',
        'nomina_id',
        'empleado_id',
        
        // Datos del empleado
        'empleado_nombre',
        'rfc',
        'curp',
        'nss',
        'puesto',
        'area',
        
        // Período
        'periodo',
        'fecha_inicio',
        'fecha_fin',
        'fecha_pago',
        'dias_pagados',
        
        // Montos
        'total_percepciones',
        'total_deducciones',
        'neto_pagar',
        
        // Datos de timbrado
        'uuid',
        'estatus_timbrado',
        'fecha_timbrado',
        'sello_cfd',
        'sello_sat',
        'no_certificado_sat',
        'cadena_original',
        
        // Archivos
        'pdf_path',
        'xml_path',
        
        // Datos de la empresa
        'empresa_razon_social',
        'empresa_rfc',
        'empresa_regimen_fiscal',
        
        // Auditoría
        'created_by',
        'timbrado_por',
        'cancelado_por',
        'observaciones',
        'motivo_cancelacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_pago' => 'date',
        'fecha_timbrado' => 'datetime',
        'total_percepciones' => 'decimal:2',
        'total_deducciones' => 'decimal:2',
        'neto_pagar' => 'decimal:2',
        'dias_pagados' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    // ============================================
    // CONSTANTES
    // ============================================

    /**
     * Estatus de timbrado disponibles
     */
    const ESTATUS_POR_TIMBRAR = 'Por Timbrar';
    const ESTATUS_TIMBRADO = 'Timbrado';
    const ESTATUS_CANCELADO = 'Cancelado';
    const ESTATUS_ERROR = 'Error';

    /**
     * Obtener todos los estatus disponibles
     */
    public static function getEstatusList()
    {
        return [
            self::ESTATUS_POR_TIMBRAR,
            self::ESTATUS_TIMBRADO,
            self::ESTATUS_CANCELADO,
            self::ESTATUS_ERROR,
        ];
    }

    /**
     * Obtener estatus con colores para badges
     */
    public static function getEstatusColors()
    {
        return [
            self::ESTATUS_POR_TIMBRAR => '#ffc107',
            self::ESTATUS_TIMBRADO => '#28a745',
            self::ESTATUS_CANCELADO => '#dc3545',
            self::ESTATUS_ERROR => '#dc3545',
        ];
    }

    /**
     * Obtener estatus con colores de texto
     */
    public static function getEstatusTextColors()
    {
        return [
            self::ESTATUS_POR_TIMBRAR => '#212529',
            self::ESTATUS_TIMBRADO => 'white',
            self::ESTATUS_CANCELADO => 'white',
            self::ESTATUS_ERROR => 'white',
        ];
    }

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación con la nómina
     */
    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'nomina_id');
    }

    /**
     * Relación con el empleado
     */
    public function empleado()
    {
        return $this->belongsTo(Plantilla::class, 'empleado_id', 'plantilla_id');
    }

    /**
     * Relación con el usuario que creó el recibo
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con el usuario que timbró el recibo
     */
    public function timbrador()
    {
        return $this->belongsTo(User::class, 'timbrado_por');
    }

    /**
     * Relación con el usuario que canceló el timbrado
     */
    public function cancelador()
    {
        return $this->belongsTo(User::class, 'cancelado_por');
    }

    // ============================================
    // SCOPES (Filtros)
    // ============================================

    /**
     * Scope para filtrar por estatus de timbrado
     */
    public function scopeEstatus($query, $estatus)
    {
        return $query->where('estatus_timbrado', $estatus);
    }

    /**
     * Scope para filtrar recibos por timbrar
     */
    public function scopePorTimbrar($query)
    {
        return $query->where('estatus_timbrado', self::ESTATUS_POR_TIMBRAR);
    }

    /**
     * Scope para filtrar recibos timbrados
     */
    public function scopeTimbrados($query)
    {
        return $query->where('estatus_timbrado', self::ESTATUS_TIMBRADO);
    }

    /**
     * Scope para filtrar recibos cancelados
     */
    public function scopeCancelados($query)
    {
        return $query->where('estatus_timbrado', self::ESTATUS_CANCELADO);
    }

    /**
     * Scope para filtrar por rango de fechas de pago
     */
    public function scopeFechaPagoEntre($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_pago', [$inicio, $fin]);
    }

    /**
     * Scope para filtrar por rango de fechas de timbrado
     */
    public function scopeFechaTimbradoEntre($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_timbrado', [$inicio, $fin]);
    }

    /**
     * Scope para filtrar por período
     */
    public function scopePeriodo($query, $periodo)
    {
        return $query->where('periodo', 'LIKE', "%{$periodo}%");
    }

    /**
     * Scope para filtrar por año
     */
    public function scopeAnio($query, $anio)
    {
        return $query->whereYear('fecha_pago', $anio);
    }

    /**
     * Scope para filtrar por mes
     */
    public function scopeMes($query, $mes)
    {
        return $query->whereMonth('fecha_pago', $mes);
    }

    /**
     * Scope para búsqueda general
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('folio', 'LIKE', "%{$termino}%")
              ->orWhere('empleado_nombre', 'LIKE', "%{$termino}%")
              ->orWhere('rfc', 'LIKE', "%{$termino}%")
              ->orWhere('uuid', 'LIKE', "%{$termino}%")
              ->orWhere('periodo', 'LIKE', "%{$termino}%")
              ->orWhere('puesto', 'LIKE', "%{$termino}%");
        });
    }

    // ============================================
    // ACCESORS (Getters)
    // ============================================

    /**
     * Obtener el color del estatus para badges
     */
    public function getEstatusColorAttribute()
    {
        $colors = self::getEstatusColors();
        return $colors[$this->estatus_timbrado] ?? '#6c757d';
    }

    /**
     * Obtener el color del texto para el estatus
     */
    public function getEstatusTextColorAttribute()
    {
        $colors = self::getEstatusTextColors();
        return $colors[$this->estatus_timbrado] ?? 'white';
    }

    /**
     * Obtener la clase CSS del badge según el estatus
     */
    public function getEstatusBadgeAttribute()
    {
        $badges = [
            self::ESTATUS_POR_TIMBRAR => 'badge-warning',
            self::ESTATUS_TIMBRADO => 'badge-success',
            self::ESTATUS_CANCELADO => 'badge-danger',
            self::ESTATUS_ERROR => 'badge-danger',
        ];

        return $badges[$this->estatus_timbrado] ?? 'badge-secondary';
    }

    /**
     * Obtener percepciones formateadas
     */
    public function getPercepcionesFormateadasAttribute()
    {
        return '$' . number_format($this->total_percepciones, 2, '.', ',');
    }

    /**
     * Obtener deducciones formateadas
     */
    public function getDeduccionesFormateadasAttribute()
    {
        return '$' . number_format($this->total_deducciones, 2, '.', ',');
    }

    /**
     * Obtener neto formateado
     */
    public function getNetoFormateadoAttribute()
    {
        return '$' . number_format($this->neto_pagar, 2, '.', ',');
    }

    /**
     * Obtener el nombre completo del empleado (alias)
     */
    public function getNombreCompletoAttribute()
    {
        return $this->empleado_nombre;
    }

    /**
     * Obtener el período formateado
     */
    public function getPeriodoFormateadoAttribute()
    {
        return $this->periodo;
    }

    /**
     * Obtener la fecha de pago formateada
     */
    public function getFechaPagoFormateadaAttribute()
    {
        return $this->fecha_pago ? $this->fecha_pago->format('d/m/Y') : '-';
    }

    /**
     * Obtener la fecha de timbrado formateada
     */
    public function getFechaTimbradoFormateadaAttribute()
    {
        return $this->fecha_timbrado ? $this->fecha_timbrado->format('d/m/Y H:i') : '—';
    }

    /**
     * Obtener el UUID corto
     */
    public function getUuidCortoAttribute()
    {
        if (!$this->uuid) {
            return '—';
        }
        return substr($this->uuid, 0, 8) . '...' . substr($this->uuid, -4);
    }

    /**
     * Verificar si el recibo está timbrado
     */
    public function getEstaTimbradoAttribute()
    {
        return $this->estatus_timbrado === self::ESTATUS_TIMBRADO;
    }

    /**
     * Verificar si el recibo está pendiente
     */
    public function getEstaPendienteAttribute()
    {
        return $this->estatus_timbrado === self::ESTATUS_POR_TIMBRAR;
    }

    /**
     * Verificar si el recibo está cancelado
     */
    public function getEstaCanceladoAttribute()
    {
        return $this->estatus_timbrado === self::ESTATUS_CANCELADO;
    }

    /**
     * Obtener el icono del estatus
     */
    public function getEstatusIconoAttribute()
    {
        $icons = [
            self::ESTATUS_TIMBRADO => 'fa-check-circle',
            self::ESTATUS_POR_TIMBRAR => 'fa-clock',
            self::ESTATUS_CANCELADO => 'fa-times-circle',
            self::ESTATUS_ERROR => 'fa-exclamation-circle',
        ];

        return $icons[$this->estatus_timbrado] ?? 'fa-circle';
    }

    // ============================================
    // MUTATORS (Setters)
    // ============================================

    /**
     * Establecer el RFC en mayúsculas
     */
    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = strtoupper(trim($value));
    }

    /**
     * Establecer el CURP en mayúsculas
     */
    public function setCurpAttribute($value)
    {
        $this->attributes['curp'] = $value ? strtoupper(trim($value)) : null;
    }

    /**
     * Establecer el UUID en mayúsculas
     */
    public function setUuidAttribute($value)
    {
        $this->attributes['uuid'] = $value ? strtoupper(trim($value)) : null;
    }

    // ============================================
    // MÉTODOS DE NEGOCIO
    // ============================================

    /**
     * Generar folio único para el recibo
     */
    public static function generarFolio()
    {
        $year = date('Y');
        $mes = date('m');
        $ultimo = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($ultimo) {
            $numero = intval(substr($ultimo->folio, -4)) + 1;
        } else {
            $numero = 1;
        }
        
        return 'R-' . $year . '-' . $mes . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generar UUID simulado para el recibo
     */
    private function generarUUID()
    {
        return strtoupper(
            substr(md5(uniqid() . microtime() . rand()), 0, 8) . '-' .
            substr(md5(uniqid() . microtime() . rand()), 8, 4) . '-' .
            substr(md5(uniqid() . microtime() . rand()), 12, 4) . '-' .
            substr(md5(uniqid() . microtime() . rand()), 16, 4) . '-' .
            substr(md5(uniqid() . microtime() . rand()), 20, 12)
        );
    }

    /**
     * Timbrar el recibo
     */
    public function timbrar($usuarioId = null)
    {
        $this->uuid = $this->generarUUID();
        $this->estatus_timbrado = self::ESTATUS_TIMBRADO;
        $this->fecha_timbrado = now();
        $this->timbrado_por = $usuarioId ?? auth()->id();
        $this->save();

        // Aquí se podría agregar lógica para:
        // - Generar el XML del CFDI
        // - Generar el PDF del recibo
        // - Guardar los archivos en el servidor
        // - Enviar notificaciones

        return $this;
    }

    /**
     * Cancelar el timbrado del recibo
     */
    public function cancelarTimbrado($motivo = null, $usuarioId = null)
    {
        if ($this->estatus_timbrado !== self::ESTATUS_TIMBRADO) {
            throw new \Exception('Solo se pueden cancelar recibos timbrados');
        }

        $this->estatus_timbrado = self::ESTATUS_CANCELADO;
        $this->cancelado_por = $usuarioId ?? auth()->id();
        $this->motivo_cancelacion = $motivo;
        $this->save();

        // Aquí se podría agregar lógica para:
        // - Generar el XML de cancelación
        // - Actualizar el estatus en el SAT
        // - Eliminar archivos del servidor

        return $this;
    }

    /**
     * Re-timbrar un recibo cancelado
     */
    public function retimbrar($usuarioId = null)
    {
        if ($this->estatus_timbrado !== self::ESTATUS_CANCELADO) {
            throw new \Exception('Solo se pueden re-timbrar recibos cancelados');
        }

        // Generar nuevo UUID
        $this->uuid = $this->generarUUID();
        $this->estatus_timbrado = self::ESTATUS_TIMBRADO;
        $this->fecha_timbrado = now();
        $this->timbrado_por = $usuarioId ?? auth()->id();
        $this->motivo_cancelacion = null;
        $this->cancelado_por = null;
        $this->save();

        return $this;
    }

    /**
     * Generar el PDF del recibo
     */
    public function generarPdf()
    {
        // Aquí se implementaría la generación del PDF
        // usando una librería como DomPDF, TCPDF, etc.
        
        // Ejemplo con DomPDF:
        // $pdf = \PDF::loadView('rh.nomina.recibo_pdf', ['recibo' => $this]);
        // $path = storage_path('app/public/recibos/' . $this->folio . '.pdf');
        // $pdf->save($path);
        // $this->pdf_path = $path;
        // $this->save();
        
        return $this;
    }

    /**
     * Generar el XML del CFDI
     */
    public function generarXml()
    {
        // Aquí se implementaría la generación del XML
        // siguiendo el estándar del SAT para nómina
        
        return $this;
    }

    /**
     * Enviar el recibo por correo
     */
    public function enviarPorCorreo($email = null)
    {
        $emailDestino = $email ?? $this->empleado->correo ?? null;
        
        if (!$emailDestino) {
            throw new \Exception('No se encontró un correo electrónico para el empleado');
        }

        // Aquí se implementaría el envío de correo
        // \Mail::to($emailDestino)->send(new ReciboNominaMail($this));
        
        return true;
    }

    /**
     * Verificar si el recibo tiene archivo PDF
     */
    public function tienePdf()
    {
        return !empty($this->pdf_path) && file_exists($this->pdf_path);
    }

    /**
     * Verificar si el recibo tiene archivo XML
     */
    public function tieneXml()
    {
        return !empty($this->xml_path) && file_exists($this->xml_path);
    }

    /**
     * Obtener la URL del PDF
     */
    public function getPdfUrl()
    {
        if (!$this->tienePdf()) {
            return null;
        }
        return asset('storage/' . $this->pdf_path);
    }

    /**
     * Obtener la URL del XML
     */
    public function getXmlUrl()
    {
        if (!$this->tieneXml()) {
            return null;
        }
        return asset('storage/' . $this->xml_path);
    }

    // ============================================
    // MÉTODOS ESTÁTICOS
    // ============================================

    /**
     * Obtener resumen por estatus
     */
    public static function getResumenEstatus()
    {
        return [
            'por_timbrar' => self::porTimbrar()->count(),
            'timbrados' => self::timbrados()->count(),
            'cancelados' => self::cancelados()->count(),
            'total' => self::count(),
        ];
    }

    /**
     * Obtener KPIs para el dashboard
     */
    public static function getKPIs()
    {
        return [
            'total' => self::count(),
            'por_timbrar' => self::porTimbrar()->count(),
            'timbrados' => self::timbrados()->count(),
            'cancelados' => self::cancelados()->count(),
            'total_percepciones' => self::sum('total_percepciones'),
            'total_deducciones' => self::sum('total_deducciones'),
            'total_neto' => self::sum('neto_pagar'),
            'timbrados_neto' => self::timbrados()->sum('neto_pagar'),
            'promedio_neto' => self::avg('neto_pagar'),
        ];
    }

    /**
     * Obtener recibos por período
     */
    public static function getPorPeriodo($periodo)
    {
        return self::where('periodo', $periodo)
            ->orderBy('fecha_pago', 'desc')
            ->get();
    }

    /**
     * Obtener recibos por empleado
     */
    public static function getPorEmpleado($empleadoId)
    {
        return self::where('empleado_id', $empleadoId)
            ->orderBy('fecha_pago', 'desc')
            ->get();
    }

    /**
     * Obtener períodos disponibles
     */
    public static function getPeriodosDisponibles()
    {
        return self::select('periodo')
            ->distinct()
            ->orderBy('periodo', 'desc')
            ->pluck('periodo')
            ->toArray();
    }

    /**
     * Obtener años disponibles
     */
    /**
 * Obtener años disponibles
 */
public static function getAniosDisponibles()
{
    // 
    return self::select(DB::raw('DISTINCT EXTRACT(YEAR FROM fecha_pago) as anio'))
        ->orderBy('anio', 'desc')
        ->pluck('anio')
        ->toArray();
}

    /**
     * Obtener meses disponibles para un año
     */
    public static function getMesesDisponibles($anio)
    {
        return self::whereYear('fecha_pago', $anio)
            ->select(\DB::raw('DISTINCT MONTH(fecha_pago) as mes'))
            ->orderBy('mes', 'desc')
            ->pluck('mes')
            ->toArray();
    }

        public function recibo()
    {
        return $this->hasOne(ReciboNomina::class, 'nomina_id');
    }

    /**
     * Verificar si la nómina ya tiene recibo
     */
    public function tieneRecibo()
    {
        return $this->recibo()->exists();
    }

}