<?php
// app/Models/Banco.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;
    
    protected $table = 'bancos';
    
    protected $fillable = [
        'nombre',
        'codigo',
        'activo'
    ];
    
    protected $casts = [
        'activo' => 'boolean'
    ];
    
    // Relaciones
    public function cuentasBancarias()
    {
        return $this->hasMany(CuentaBancaria::class);
    }
    
    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
    
    // Métodos
    public function getNombreCompletoAttribute()
    {
        return $this->codigo ? "{$this->nombre} ({$this->codigo})" : $this->nombre;
    }
}