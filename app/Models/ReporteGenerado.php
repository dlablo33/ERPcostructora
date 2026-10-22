<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteGenerado extends Model
{
    protected $table = 'reportes_generados'; // ajusta si tu tabla se llama distinto

    protected $fillable = [
        'titulo',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'proyecto_id',
        'generado_por',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    /**
     * ✨ Relación con el proyecto
     * Nota: `proyecto_id` en reportes_generados guarda el CÓDIGO del proyecto
     * (ej: "PRO-2024-001"), no el id numérico. Por eso la relación apunta
     * a la columna `codigo` de la tabla proyectos.
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'codigo');
    }

    public function generador()
    {
        return $this->belongsTo(User::class, 'generado_por', 'id');
    }
}