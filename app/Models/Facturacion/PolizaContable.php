<?php

namespace App\Models\Facturacion;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolizaContable extends Model
{
    use SoftDeletes;

    protected $table = 'polizas_contables';
    protected $primaryKey = 'poliza_contable_id';
    protected $fillable = ['folio', 'fecha', 'origen', 'origen_id', 'total_debe', 'total_haber', 'descripcion', 'tipo', 'created_by'];
    protected $casts = ['fecha' => 'date', 'total_debe' => 'decimal:2', 'total_haber' => 'decimal:2'];

    public function movimientos() { return $this->hasMany(PolizaMovimiento::class, 'poliza_contable_id'); }
    public function usuario() { return $this->belongsTo(User::class, 'created_by'); }
}