<?php
// app/Models/CategoriaGasto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGasto extends Model
{
    use HasFactory;
    
    protected $table = 'categorias_gastos';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_egreso_id',
        'activo'
    ];
    
    protected $casts = [
        'activo' => 'boolean'
    ];
    
    // Relaciones
    public function tipoEgreso()
    {
        return $this->belongsTo(TipoEgreso::class);
    }
    
    public function movimientos()
    {
        return $this->hasMany(MovimientoBancario::class, 'categoria_gasto_id');
    }
    
    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
    
    public function scopePorTipoEgreso($query, $tipoEgresoId)
    {
        return $query->where('tipo_egreso_id', $tipoEgresoId);
    }
}