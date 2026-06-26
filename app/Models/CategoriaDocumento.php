<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaDocumento extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categorias_documentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'descripcion',
        'activo',
        'parent_id',
        'orden'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(CategoriaDocumento::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function hijos(): HasMany
    {
        return $this->hasMany(CategoriaDocumento::class, 'parent_id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Get the full code with parent prefix.
     */
    public function getCodigoCompletoAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->codigo . '-' . $this->codigo;
        }
        return $this->codigo;
    }
}