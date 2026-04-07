<?php
// app/Models/TipoIngreso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIngreso extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_ingreso';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo'
    ];
    
    protected $casts = [
        'activo' => 'boolean'
    ];
    
    // Relaciones
    public function movimientos()
    {
        return $this->hasMany(MovimientoBancario::class, 'tipo_ingreso_id');
    }
    
    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}