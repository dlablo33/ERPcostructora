<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaEvidencia extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categorias_evidencia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'icono',
        'color',
        'orden',
        'activo'
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
     * Get the evidencias for the category.
     */
    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class, 'categoria_id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope a query to order by the order field.
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }

    /**
     * Get the formatted category name with icon.
     */
    public function getNombreConIconoAttribute(): string
    {
        return '<i class="fas ' . $this->icono . '" style="color: ' . $this->color . ';"></i> ' . $this->nombre;
    }

    /**
     * Get the badge HTML for the category.
     */
    public function getBadgeAttribute(): string
    {
        return '<span style="background-color: ' . $this->color . '; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">' . $this->nombre . '</span>';
    }

    /**
     * Get the total count of evidencias for this category.
     */
    public function getTotalEvidenciasAttribute(): int
    {
        return $this->evidencias()->count();
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->codigo)) {
                $model->codigo = strtoupper(substr($model->nombre, 0, 3)) . '_' . uniqid();
            }
        });
    }
}