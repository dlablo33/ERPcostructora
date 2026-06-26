<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComentario extends Model
{
    use HasFactory;

    protected $table = 'ticket_comentarios';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'comentario',
        'es_interno'
    ];

    protected $casts = [
        'es_interno' => 'boolean'
    ];

    // Relaciones
    public function ticket()
    {
        return $this->belongsTo(ClientTicket::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}