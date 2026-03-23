<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatBanco extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cat_bancos';
    protected $primaryKey = 'cat_banco_id';

    protected $fillable = [
        'clave',
        'descripcion',
        'nombre_corto',
        'rfc',
        'activo',
        'borrado_logico'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'borrado_logico' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // ============================================
    // RELACIONES
    // ============================================
    
    /**
     * Relación con Plantilla (empleados)
     * Un banco puede tener muchos empleados asociados
     */
    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'cat_bancos_clave', 'clave');
    }

    /**
     * Relación con PlantillaTipoCuenta
     */
    public function plantillasTiposCuentas()
    {
        return $this->hasMany(PlantillaTipoCuenta::class, 'cat_banco_id');
    }

    // ============================================
    // SCOPES
    // ============================================
    
    /**
     * Scope para obtener solo bancos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true)
                     ->where('borrado_logico', false);
    }

    /**
     * Scope para búsqueda por texto
     */
    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where(function($q) use ($termino) {
                $q->where('descripcion', 'ILIKE', "%{$termino}%")
                  ->orWhere('nombre_corto', 'ILIKE', "%{$termino}%")
                  ->orWhere('clave', 'ILIKE', "%{$termino}%")
                  ->orWhere('rfc', 'ILIKE', "%{$termino}%");
            });
        }
        return $query;
    }

    /**
     * Scope para ordenar por nombre
     */
    public function scopeOrdenado($query, $columna = 'nombre_corto', $direccion = 'asc')
    {
        return $query->orderBy($columna, $direccion);
    }

    // ============================================
    // ACCESORES
    // ============================================
    
    /**
     * Accesor para obtener el nombre completo del banco
     */
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre_corto . ' - ' . $this->descripcion);
    }

    /**
     * Accesor para obtener la clave con nombre
     */
    public function getClaveNombreAttribute()
    {
        return $this->clave . ' - ' . $this->nombre_corto;
    }

    /**
     * Accesor para saber si está activo en texto
     */
    public function getActivoTextoAttribute()
    {
        return $this->activo ? 'Activo' : 'Inactivo';
    }

    // ============================================
    // MUTADORES
    // ============================================
    
    /**
     * Mutador para asegurar que la clave sea siempre mayúscula
     */
    public function setClaveAttribute($value)
    {
        $this->attributes['clave'] = strtoupper(trim($value));
    }

    /**
     * Mutador para asegurar que el RFC sea siempre mayúscula
     */
    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = $value ? strtoupper(trim($value)) : null;
    }

    /**
     * Mutador para asegurar que el nombre corto sea capitalizado
     */
    public function setNombreCortoAttribute($value)
    {
        $this->attributes['nombre_corto'] = $value ? strtoupper(trim($value)) : null;
    }

    // ============================================
    // MÉTODOS ADICIONALES
    // ============================================
    
    /**
     * Verificar si el banco puede ser eliminado
     * (No tiene empleados asociados)
     */
    public function puedeEliminarse()
    {
        return $this->plantillas()->count() === 0;
    }

    /**
     * Obtener el conteo de empleados asociados
     */
    public function getEmpleadosCountAttribute()
    {
        return $this->plantillas()->count();
    }
}