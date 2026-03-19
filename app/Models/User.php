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

    // Scope para búsqueda
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

    // Scope para activos
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }

    // Scope para inactivos
    public function scopeInactivos($query)
    {
        return $query->where('estatus', 'Inactivo');
    }
}