<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketArchivo extends Model
{
    use HasFactory;

    protected $table = 'ticket_archivos';

    protected $fillable = [
        'ticket_id',
        'nombre_original',
        'nombre_unico',
        'ruta',
        'tamaño',
        'mime_type'
    ];

    // Relación
    public function ticket()
    {
        return $this->belongsTo(ClientTicket::class);
    }
}