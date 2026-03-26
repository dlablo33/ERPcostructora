<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'folio',
        'name',
        'email',
        'password',
        'empleado',
        'rol',
        'estatus',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'estatus' => 'string',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    // Relación con Plantilla (un usuario puede estar asociado a un empleado)
    public function plantilla()
    {
        return $this->hasOne(Plantilla::class, 'user_id');
    }

    // Relación con Asistencias (registros de asistencia del usuario)
    public function asistencias()
    {
        return $this->hasMany(\App\Models\RH\Asistencia::class, 'user_id');
    }

    // Relación con asistencias que registró
    public function asistenciasRegistradas()
    {
        return $this->hasMany(\App\Models\RH\Asistencia::class, 'registrado_por');
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('name', 'LIKE', "%{$termino}%")
                         ->orWhere('folio', 'LIKE', "%{$termino}%")
                         ->orWhere('email', 'LIKE', "%{$termino}%")
                         ->orWhere('empleado', 'LIKE', "%{$termino}%")
                         ->orWhere('rol', 'LIKE', "%{$termino}%");
        }
        return $query;
    }

    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estatus', 'Inactivo');
    }
}