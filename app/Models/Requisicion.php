<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisicion extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'requisiciones';
    
    protected $fillable = [
        'folio',
        'fecha_requerimiento',
        'estatus',
        'solicitante',
        'area',
        'area_id',
        'proyecto_id',
        'cotizadas',
        'observaciones',
        'creado_por',
        'aprobado_por',
        'fecha_aprobacion',
        'motivo_rechazo'
    ];
    
    protected $casts = [
        'fecha_requerimiento' => 'date',
        'fecha_aprobacion' => 'datetime',
    ];
    
    // Relación con área
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function articulos()
    {
        return $this->hasMany(RequisicionArticulo::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
}