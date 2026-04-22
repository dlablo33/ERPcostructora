<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subfamilia extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'subfamilias';
    
    protected $fillable = [
        'codigo',
        'familia_id',
        'nombre',
        'descripcion',
        'cuenta_contable',
        'estatus'
    ];
    
    protected $casts = [
        'estatus' => 'string'
    ];
    
    // Relación con familia
    public function familia()
    {
        return $this->belongsTo(Familia::class);
    }
    
    // Accesor para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }
    
    // Scope para activos
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }
    
    // Generar código automático
    public static function generarCodigo()
    {
        $ultima = self::withTrashed()->orderBy('id', 'desc')->first();
        if ($ultima && $ultima->codigo) {
            $numero = intval(substr($ultima->codigo, 4)) + 1;
        } else {
            $numero = 1;
        }
        return 'SUB-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }
}