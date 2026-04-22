<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Articulo extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'articulos';
    
    protected $fillable = [
        'codigo',
        'descripcion',
        'numero_parte',
        'familia_id',
        'subfamilia_id',
        'ubicacion',
        'minimo',
        'maximo',
        'punto_reorden',
        'unidad_medida',
        'cuenta_contable',
        'estatus'
    ];
    
    protected $casts = [
        'minimo' => 'decimal:3',
        'maximo' => 'decimal:3',
        'punto_reorden' => 'decimal:3'
    ];
    
    // Relaciones
    public function familia()
    {
        return $this->belongsTo(Familia::class);
    }
    
    public function subfamilia()
    {
        return $this->belongsTo(Subfamilia::class);
    }
    
    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }
    
    // Generar código automático
    public static function generarCodigo()
    {
        $ultimo = self::withTrashed()->orderBy('id', 'desc')->first();
        if ($ultimo && $ultimo->codigo) {
            $numero = intval(substr($ultimo->codigo, 4)) + 1;
        } else {
            $numero = 1;
        }
        return 'ART-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
}