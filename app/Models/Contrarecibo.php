<?php
// app/Models/Contrarecibo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrarecibo extends Model
{
    use SoftDeletes;

    protected $table = 'contrarecibos';
    protected $primaryKey = 'contrarecibo_id';
    
    protected $fillable = [
        'folio',
        'serie',
        'fecha_pago',
        'contacto_id',
        'monto',
        'saldo_aplicado',
        'forma_pago',
        'referencia_bancaria',
        'cuenta_origen',
        'cuenta_destino',
        'observaciones',
        'estatus',
        'created_by'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
        'saldo_aplicado' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'contacto_id', 'contacto_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function facturas()
    {
        return $this->belongsToMany(Factura::class, 'contrarecibo_facturas', 'contrarecibo_id', 'factura_id')
                    ->withPivot('monto_aplicado')
                    ->withTimestamps();
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estatus', 1);
    }

    public function scopeAplicados($query)
    {
        return $query->where('estatus', 19);
    }

    public function scopeCancelados($query)
    {
        return $query->where('estatus', 21);
    }

    // Métodos de ayuda
    public function getEstatusTextoAttribute()
    {
        $map = [1 => 'Pendiente', 19 => 'Aplicado', 21 => 'Cancelado'];
        return $map[$this->estatus] ?? 'Desconocido';
    }

    public function getBadgeClassAttribute()
    {
        $map = [1 => 'badge-pendiente', 19 => 'badge-aplicado', 21 => 'badge-cancelado'];
        return $map[$this->estatus] ?? 'badge-pendiente';
    }
}