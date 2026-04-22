<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacen extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'almacenes';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'descripcion',
        'ubicacion',
        'responsable',
        'telefono',
        'email',
        'cuenta_contable',
        'estatus'
    ];
    
    protected $casts = [
        'estatus' => 'string'
    ];
    
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
        return 'ALM-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }
    
    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }
}