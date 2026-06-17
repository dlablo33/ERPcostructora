<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CostoDirectoDocumento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'costos_directos_documentos';

    protected $fillable = [
        'costo_directo_id',
        'nombre_original',
        'nombre_unico',
        'ruta',
        'tipo',
        'tamanio',
        'descripcion',
        'orden'
    ];

    protected $casts = [
        'tamanio' => 'integer',
        'orden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'tamanio_formateado',
        'icono'
    ];

    // ==================== RELACIONES ====================

    public function costoDirecto()
    {
        return $this->belongsTo(CostoDirecto::class, 'costo_directo_id');
    }

    // ==================== ACCESSORS ====================

    public function getTamanioFormateadoAttribute(): string
    {
        $tamanio = $this->tamanio;
        $unidades = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($tamanio >= 1024 && $i < count($unidades) - 1) {
            $tamanio /= 1024;
            $i++;
        }
        return round($tamanio, 2) . ' ' . $unidades[$i];
    }

    public function getIconoAttribute(): string
    {
        $tipos = [
            'application/pdf' => 'fa-file-pdf',
            'image/jpeg' => 'fa-file-image',
            'image/png' => 'fa-file-image',
            'application/msword' => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa-file-word',
            'application/vnd.ms-excel' => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fa-file-excel',
            'application/zip' => 'fa-file-archive'
        ];
        return $tipos[$this->tipo] ?? 'fa-file';
    }

    public function getColorIconoAttribute(): string
    {
        $colores = [
            'application/pdf' => '#dc3545',
            'image/jpeg' => '#28a745',
            'image/png' => '#28a745',
            'application/msword' => '#007bff',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '#007bff',
            'application/vnd.ms-excel' => '#28a745',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '#28a745',
            'application/zip' => '#6c757d'
        ];
        return $colores[$this->tipo] ?? '#6c757d';
    }

    // ==================== SCOPES ====================

    public function scopeByCostoDirecto($query, $costoDirectoId)
    {
        return $query->where('costo_directo_id', $costoDirectoId);
    }

    public function scopeByTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo', 'LIKE', "%{$tipo}%");
        }
        return $query;
    }

    // ==================== MÉTODOS ====================

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->ruta);
    }

    public function getPathAttribute(): string
    {
        return storage_path('app/public/' . $this->ruta);
    }
}