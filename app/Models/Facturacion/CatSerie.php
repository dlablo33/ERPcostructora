<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Model;

class CatSerie extends Model
{
    protected $table = 'cat_series';
    protected $primaryKey = 'cat_serie_id';
    
    protected $fillable = [
        'serie', 'descripcion', 'datos_generales_id', 'cat_tipo_comprobante', 
        'folio_actual', 'folio_final', 'satcat_csd_id', 'activo'
    ];
    
    protected $casts = [
        'activo' => 'boolean', 
        'folio_actual' => 'integer', 
        'folio_final' => 'integer'
    ];

    // Relaciones existentes
    public function datosGenerales() { return $this->belongsTo(DatosGenerales::class, 'datos_generales_id'); }
    public function tipoComprobante() { return $this->belongsTo(CatTipoComprobante::class, 'cat_tipo_comprobante', 'clave'); }
    public function facturas() { return $this->hasMany(Factura::class, 'cat_serie_id'); }

    // NUEVOS SCOPES
    public function scopeActivas($q) { return $q->where('activo', true); }
    public function scopeFacturas($q) { return $q->where('cat_tipo_comprobante', 'I'); }
    public function scopeNotasCredito($q) { return $q->where('cat_tipo_comprobante', 'E'); }

    // Métodos existentes
    public static function getFolioSiguiente($catSerieId)
    {
        $serie = self::find($catSerieId);
        if (!$serie) return 1;
        $nuevoFolio = $serie->folio_actual + 1;
        $serie->folio_actual = $nuevoFolio;
        $serie->save();
        return $nuevoFolio;
    }

    // NUEVOS MÉTODOS
    public function esNotaCredito()
    {
        return $this->cat_tipo_comprobante === 'E';
    }

    public function esFactura()
    {
        return $this->cat_tipo_comprobante === 'I' || $this->cat_tipo_comprobante === null;
    }
}