<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DesarrolladorAcceso extends Model
{
    use HasFactory;

    protected $table = 'desarrolladores_acceso';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'token_acceso',
        'activo',
        'ultimo_acceso'
    ];

    protected $hidden = [
        'password',
        'token_acceso'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ultimo_acceso' => 'datetime'
    ];

    // Relación con tickets
    public function tickets()
    {
        return $this->hasMany(ClientTicket::class, 'desarrollador_id');
    }

    // Métodos de autenticación
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function generateToken()
    {
        $this->token_acceso = bin2hex(random_bytes(32));
        $this->save();
        return $this->token_acceso;
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}