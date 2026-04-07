<?php
// app/Models/TipoEgreso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEgreso extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_egreso';
    
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
        return $this->hasMany(MovimientoBancario::class, 'tipo_egreso_id');
    }
    
    public function categorias()
    {
        return $this->hasMany(CategoriaGasto::class);
    }
    
    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}