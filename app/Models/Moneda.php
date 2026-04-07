<?php
// app/Models/Moneda.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use HasFactory;
    
    protected $fillable = ['codigo', 'nombre', 'simbolo', 'activa'];
    
    public function cuentasBancarias()
    {
        return $this->hasMany(CuentaBancaria::class);
    }
    
    public function tiposCambioOrigen()
    {
        return $this->hasMany(TipoCambio::class, 'moneda_origen_id');
    }
    
    public function tiposCambioDestino()
    {
        return $this->hasMany(TipoCambio::class, 'moneda_destino_id');
    }
}