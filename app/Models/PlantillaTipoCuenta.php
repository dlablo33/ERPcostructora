<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantillaTipoCuenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plantillas_tipos_cuentas';
    protected $primaryKey = 'plantilla_tipo_cuenta_id';

    protected $fillable = [
        'plantilla_id',
        'cat_tipo_cuenta_id',
        'cuenta',
        'cuenta_clabe',
        'alias',
        'cat_banco_id',
        'principal',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'principal' => 'boolean',
        'activo' => 'boolean',
        'borrado_logico' => 'boolean'
    ];

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id');
    }

    public function tipoCuenta()
    {
        return $this->belongsTo(CatTipoCuenta::class, 'cat_tipo_cuenta_id');
    }

    public function banco()
    {
        return $this->belongsTo(CatBanco::class, 'cat_banco_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->where('borrado_logico', false);
    }

    public function scopePrincipales($query)
    {
        return $query->where('principal', true);
    }
}