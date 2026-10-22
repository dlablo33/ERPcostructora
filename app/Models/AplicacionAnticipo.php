<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AplicacionAnticipo extends Model
{
    use HasFactory;

    protected $table = 'aplicacion_anticipos';

    protected $fillable = [
        'anticipo_id',
        'user_id',
        'monto',
        'fecha',
        'observaciones',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'date',
    ];

    public function anticipo()
    {
        return $this->belongsTo(Anticipo::class, 'anticipo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}