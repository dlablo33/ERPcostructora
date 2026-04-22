<?php
// app/Models/Proveedor.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'proveedores';
    
    protected $fillable = [
        'nombre',
        'rfc',
        'email',
        'telefono',
        'contacto',
        'direccion',
        'activo'
    ];
    
    protected $casts = [
        'activo' => 'boolean'
    ];
    
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
    
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    
    
}