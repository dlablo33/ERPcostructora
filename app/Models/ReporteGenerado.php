<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteGenerado extends Model
{
    protected $table = 'reportes_generados';

    protected $fillable = [
        'titulo',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'proyecto_id',
        'archivo_ruta',
        'generado_por'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function generador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generado_por');
    }

    // Accessors
    public function getTipoLabelAttribute(): string
    {
        return match($this->tipo) {
            'diario' => 'Reporte Diario',
            'semanal' => 'Reporte Semanal',
            'mensual' => 'Reporte Mensual',
            'personalizado' => 'Reporte Personalizado',
            default => 'Reporte'
        };
    }

    public function getRangoFechasAttribute(): string
    {
        return $this->fecha_inicio->format('d/m/Y') . ' - ' . $this->fecha_fin->format('d/m/Y');
    }

    public function getArchivoUrlAttribute(): ?string
    {
        if ($this->archivo_ruta && Storage::disk('public')->exists($this->archivo_ruta)) {
            return Storage::disk('public')->url($this->archivo_ruta);
        }
        return null;
    }

    // Scopes
    public function scopePorTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo', $tipo);
        }
        return $query;
    }

    public function scopePorProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }
}