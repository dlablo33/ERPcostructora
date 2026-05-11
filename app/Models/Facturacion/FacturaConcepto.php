<?php

namespace App\Models\Facturacion;

use App\Models\Articulo;
use App\Models\ProyectoPartida;
use Illuminate\Database\Eloquent\Model;

class FacturaConcepto extends Model
{
    protected $table = 'facturas_conceptos';
    protected $primaryKey = 'factura_concepto_id';
    protected $fillable = [
        'factura_id', 'partida_id', 'articulo_id', 'descripcion', 'cantidad',
        'satcat_unidades_clave', 'valor_unitario', 'importe', 'descuento', 'subtotal',
        'iva', 'tasa_iva', 'satcat_clave_productos_clave',
    ];

    protected $casts = [
        'cantidad' => 'decimal:4', 'valor_unitario' => 'decimal:4', 'importe' => 'decimal:2',
        'descuento' => 'decimal:2', 'subtotal' => 'decimal:2', 'iva' => 'decimal:2', 'tasa_iva' => 'decimal:4',
    ];

    public function factura() { return $this->belongsTo(Factura::class, 'factura_id'); }
    public function partida() { return $this->belongsTo(ProyectoPartida::class, 'partida_id'); }
    public function articulo() { return $this->belongsTo(Articulo::class, 'articulo_id'); }
    public function unidad() { return $this->belongsTo(SatcatUnidad::class, 'satcat_unidades_clave', 'clave'); }
    public function claveProducto() { return $this->belongsTo(SatcatClaveProducto::class, 'satcat_clave_productos_clave', 'clave'); }
}