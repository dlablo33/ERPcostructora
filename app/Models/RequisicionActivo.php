<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequisicionActivo extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'requisiciones_activos';
    
    protected $fillable = [
        'folio',
        'proyecto_id',
        'activo_id',
        'cantidad',
        'fecha_requisicion',
        'fecha_requerida',
        'fecha_estimada_devolucion',
        'solicitante',
        'area',
        'prioridad',
        'motivo',
        'observaciones',
        'estatus',
        'autorizado_por',
        'fecha_autorizacion',
        'motivo_rechazo',
        'creado_por'
    ];
    
    protected $casts = [
        'fecha_requisicion' => 'date',
        'fecha_requerida' => 'date',
        'fecha_estimada_devolucion' => 'date',
        'fecha_autorizacion' => 'datetime'
    ];
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }
    
    public function autorizador()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    public function asignacion()
    {
        return $this->hasOne(AsignacionActivo::class);
    }
    
    public static function generarFolio()
    {
        $ultimo = self::withTrashed()->orderBy('id', 'desc')->first();
        if ($ultimo && $ultimo->folio) {
            $numero = intval(substr($ultimo->folio, 4)) + 1;
        } else {
            $numero = 1;
        }
        return 'REQ-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
    
    public function autorizar($autorizadoPor, $observaciones = null)
    {
        $this->update([
            'estatus' => 'Aprobada',
            'autorizado_por' => $autorizadoPor,
            'fecha_autorizacion' => now(),
            'observaciones' => $observaciones
        ]);
        
        return true;
    }
    
    public function rechazar($autorizadoPor, $motivo)
    {
        $this->update([
            'estatus' => 'Rechazada',
            'autorizado_por' => $autorizadoPor,
            'fecha_autorizacion' => now(),
            'motivo_rechazo' => $motivo
        ]);
        
        return true;
    }
}