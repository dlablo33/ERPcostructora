<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequisicionMaterial extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'requisiciones_material';
    
    protected $fillable = [
        'proyecto_id',
        'folio',
        'fecha_requisicion',
        'solicitante',
        'area',
        'prioridad',
        'estatus',
        'autorizado_por',
        'fecha_autorizacion',
        'motivo_rechazo',
        'observaciones',
        'creado_por'
    ];
    
    protected $casts = [
        'fecha_requisicion' => 'date',
        'fecha_autorizacion' => 'datetime'
    ];
    
    // Relaciones
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    
    public function detalles()
    {
        return $this->hasMany(RequisicionMaterialDetalle::class, 'requisicion_id');
    }
    
    public function autorizador()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    
    // Accessors
    public function getEstaCompletaAttribute()
    {
        foreach ($this->detalles as $detalle) {
            if ($detalle->cantidad_surtida < $detalle->cantidad_autorizada) {
                return false;
            }
        }
        return true;
    }
    
    public function getPorcentajeSurtidoAttribute()
    {
        $totalSolicitado = $this->detalles->sum('cantidad_autorizada');
        $totalSurtido = $this->detalles->sum('cantidad_surtida');
        
        if ($totalSolicitado <= 0) return 0;
        
        return round(($totalSurtido / $totalSolicitado) * 100, 2);
    }
    
    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estatus', 'Pendiente');
    }
    
    public function scopeAutorizadas($query)
    {
        return $query->where('estatus', 'Autorizada');
    }
    
    // Métodos
    public function autorizar($autorizadoPor, $observaciones = null)
    {
        $this->update([
            'estatus' => 'Autorizada',
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
    
    public function generarFolio()
    {
        $ultima = self::withTrashed()->orderBy('id', 'desc')->first();
        if ($ultima && $ultima->folio) {
            $numero = intval(substr($ultima->folio, 4)) + 1;
        } else {
            $numero = 1;
        }
        return 'REQ-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
}