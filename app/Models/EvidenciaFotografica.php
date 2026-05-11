<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EvidenciaFotografica extends Model
{
    protected $table = 'evidencia_fotografica';

    protected $fillable = [
        'bitacora_entry_id',
        'ruta',
        'nombre_original',
        'mime_type',
        'size',
        'descripcion'
    ];

    protected $casts = [
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function bitacoraEntry(): BelongsTo
    {
        return $this->belongsTo(BitacoraEntry::class, 'bitacora_entry_id');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->ruta);
    }

    public function getSizeFormattedAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getEsImagenAttribute(): bool
    {
        return in_array($this->mime_type, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']);
    }

    // Métodos
    public function deleteFile(): bool
    {
        if (Storage::disk('public')->exists($this->ruta)) {
            return Storage::disk('public')->delete($this->ruta);
        }
        return false;
    }

    protected static function booted()
    {
        static::deleting(function ($evidencia) {
            $evidencia->deleteFile();
        });
    }
}