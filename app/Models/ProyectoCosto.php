<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoCosto extends Model
{
    protected $table = 'proyecto_costos';
    
    protected $fillable = [
        'proyecto_id',
        'materiales',
        'mano_obra',
        'maquinaria',
        'subcontratos',      // ← NUEVA COLUMNA AGREGADA
        'gastos_indirectos'
    ];

    protected $casts = [
        'materiales' => 'decimal:2',
        'mano_obra' => 'decimal:2',
        'maquinaria' => 'decimal:2',
        'subcontratos' => 'decimal:2',      // ← CAST PARA SUBCONTRATOS
        'gastos_indirectos' => 'decimal:2',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    /**
     * Calcula el costo total incluyendo subcontratos
     */
    public function getTotalAttribute()
    {
        return $this->materiales + 
               $this->mano_obra + 
               $this->maquinaria + 
               $this->subcontratos +      // ← INCLUIR SUBCONTRATOS EN EL TOTAL
               $this->gastos_indirectos;
    }

    /**
     * Calcula el costo directo (materiales + mano de obra + maquinaria)
     */
    public function getCostoDirectoAttribute()
    {
        return $this->materiales + $this->mano_obra + $this->maquinaria;
    }

    /**
     * Calcula el costo indirecto (subcontratos + gastos indirectos)
     */
    public function getCostoIndirectoAttribute()
    {
        return $this->subcontratos + $this->gastos_indirectos;
    }

    /**
     * Obtiene el porcentaje de cada componente respecto al total
     */
    public function getPorcentajesAttribute()
    {
        $total = $this->total;
        
        if ($total == 0) {
            return [
                'materiales' => 0,
                'mano_obra' => 0,
                'maquinaria' => 0,
                'subcontratos' => 0,
                'gastos_indirectos' => 0,
            ];
        }
        
        return [
            'materiales' => round(($this->materiales / $total) * 100, 2),
            'mano_obra' => round(($this->mano_obra / $total) * 100, 2),
            'maquinaria' => round(($this->maquinaria / $total) * 100, 2),
            'subcontratos' => round(($this->subcontratos / $total) * 100, 2),
            'gastos_indirectos' => round(($this->gastos_indirectos / $total) * 100, 2),
        ];
    }
}