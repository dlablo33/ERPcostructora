<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComentarioBitacora extends Model
{
    protected $table = 'comentarios_bitacora';

    protected $fillable = [
        'bitacora_entry_id',
        'user_id',
        'comentario'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function bitacoraEntry(): BelongsTo
    {
        return $this->belongsTo(BitacoraEntry::class, 'bitacora_entry_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessors
    public function getComentarioResumidoAttribute(): string
    {
        return strlen($this->comentario) > 100 
            ? substr($this->comentario, 0, 100) . '...' 
            : $this->comentario;
    }

    public function getTiempoTranscurridoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}