<?php

namespace App\Models\Config;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInfo extends Model
{


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'razon_social',
        'nombre_comercial',
        'rfc',
        'regimen_fiscal',
        'login_logo_path', 
        'telefono',
        'email',
        'email_facturacion',
        'website',
        'calle',
        'num_exterior',
        'num_interior',
        'colonia',
        'codigo_postal',
        'municipio',
        'estado',
        'pais',
        'satcat_regimen_fiscal_clave',
        'satcat_uso_cfdi_clave',
        'certificado_cer',
        'certificado_key',
        'certificado_password',
        'certificado_no_serie',
        'certificado_vigencia_desde',
        'certificado_vigencia_hasta',
        'logo_path',
        'logo_small_path',
        'favicon_path',
        'serie_default',
        'folio_actual',
        'folio_siguiente',
        'autotimbrado',
        'mensaje_factura',
        'terminos_condiciones',
        'politica_privacidad',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'autotimbrado' => 'boolean',
        'certificado_vigencia_desde' => 'datetime',
        'certificado_vigencia_hasta' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who created this record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this record.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the full address as a string.
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->calle,
            $this->num_exterior,
            $this->num_interior ? 'Int. ' . $this->num_interior : null,
            $this->colonia,
            $this->codigo_postal,
            $this->municipio,
            $this->estado,
            $this->pais,
        ];

        return implode(', ', array_filter($parts));
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    /**
     * Get the logo small URL.
     */
    public function getLogoSmallUrlAttribute()
    {
        return $this->logo_small_path ? asset('storage/' . $this->logo_small_path) : null;
    }

    /**
     * Get the favicon URL.
     */
    public function getFaviconUrlAttribute()
    {
        return $this->favicon_path ? asset('storage/' . $this->favicon_path) : null;
    }

    /**
     * Check if certificate is valid.
     */
    public function getIsCertificateValidAttribute()
    {
        if (!$this->certificado_vigencia_hasta) {
            return false;
        }
        return $this->certificado_vigencia_hasta->isFuture();
    }

    /**
     * Get the next folio number.
     */
    public function getNextFolioAttribute()
    {
        return $this->folio_siguiente ?? $this->folio_actual + 1;
    }

    /**
     * Increment the folio counter.
     */
    public function incrementFolio()
    {
        $this->folio_actual = $this->next_folio;
        $this->folio_siguiente = $this->folio_actual + 1;
        $this->save();
        return $this->folio_actual;
    }
}