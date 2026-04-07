<?php
// app/Models/TipoCambio.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_cambio';
    
    protected $fillable = [
        'moneda_origen_id',
        'moneda_destino_id',
        'tasa',
        'fecha'
    ];
    
    protected $casts = [
        'tasa' => 'decimal:4',
        'fecha' => 'date'
    ];
    
    // Relaciones
    public function monedaOrigen()
    {
        return $this->belongsTo(Moneda::class, 'moneda_origen_id');
    }
    
    public function monedaDestino()
    {
        return $this->belongsTo(Moneda::class, 'moneda_destino_id');
    }
    
    // Scopes
    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }
    
    public function scopePorMonedas($query, $origenId, $destinoId)
    {
        return $query->where('moneda_origen_id', $origenId)
                     ->where('moneda_destino_id', $destinoId);
    }
    
    // Métodos
    public function convertir($monto)
    {
        return $monto * $this->tasa;
    }
    
    public function convertirInverso($monto)
    {
        return $monto / $this->tasa;
    }
}