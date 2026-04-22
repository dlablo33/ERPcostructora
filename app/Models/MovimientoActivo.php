<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovimientoActivo extends Model
{
    use HasFactory;
    
    protected $table = 'movimientos_activos';
    
    protected $fillable = [
        'activo_id',
        'tipo_movimiento',
        'fecha_movimiento',
        'proyecto_origen_id',
        'proyecto_destino_id',
        'responsable_origen',
        'responsable_destino',
        'horometro_km',
        'observaciones',
        'creado_por'
    ];
    
    protected $casts = [
        'fecha_movimiento' => 'datetime',
        'horometro_km' => 'decimal:1'
    ];
    
    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }
    
    public function proyectoOrigen()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_origen_id');
    }
    
    public function proyectoDestino()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_destino_id');
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}