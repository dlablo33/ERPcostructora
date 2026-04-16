<?php
// app/Models/CuentaContable.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaContable extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'cuentas_contables';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'naturaleza',
        'codigo_padre',
        'nivel',
        'auxiliar',
        'activa',
        'descripcion'
    ];
    
    protected $casts = [
        'auxiliar' => 'boolean',
        'activa' => 'boolean'
    ];
    
    // Relaciones
    public function padre()
    {
        return $this->belongsTo(CuentaContable::class, 'codigo_padre', 'codigo');
    }
    
    public function hijos()
    {
        return $this->hasMany(CuentaContable::class, 'codigo_padre', 'codigo');
    }
    
    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
    
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
    
    // Accessors
    public function getNivelTextoAttribute()
    {
        $niveles = ['', 'Principal', 'Subcuenta', 'Auxiliar', 'Detalle'];
        return $niveles[$this->nivel] ?? 'Nivel ' . $this->nivel;
    }
    
    public function getTipoColorAttribute()
    {
        $colores = [
            'activo' => 'success',
            'pasivo' => 'danger',
            'capital' => 'primary',
            'ingreso' => 'info',
            'gasto' => 'warning',
            'costo' => 'secondary'
        ];
        return $colores[$this->tipo] ?? 'secondary';
    }
}