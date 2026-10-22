<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacen extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'almacenes';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'descripcion',
        'ubicacion',
        'responsable',
        'responsable_id',
        'telefono',
        'email',
        'cuenta_contable',
        'cuenta_contable_id',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'string',
    ];

    /* ============================================
       RELACIONES
       ============================================ */

    /**
     * Usuario responsable del almacén.
     */
    public function responsableUsuario()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Cuenta contable asociada al almacén.
     */
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }

    /* ============================================
       SCOPES
       ============================================ */

    public function scopeActivos($query)
    {
        return $query->where('estatus', 'Activo');
    }

    /* ============================================
       HELPERS
       ============================================ */

    /**
     * Generar código automático.
     */
    public static function generarCodigo()
    {
        $ultimo = self::withTrashed()->orderBy('id', 'desc')->first();
        if ($ultimo && $ultimo->codigo) {
            $numero = intval(substr($ultimo->codigo, 4)) + 1;
        } else {
            $numero = 1;
        }
        return 'ALM-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Nombre completo del almacén.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }

    /**
     * Sincroniza las columnas de texto con las FKs.
     * Llama a esto antes de guardar o en el controller.
     */
    public function sincronizarResponsable()
    {
        if ($this->responsable_id) {
            $user = User::find($this->responsable_id);
            $this->responsable = $user ? $user->name : null;
        }
    }

    public function sincronizarCuentaContable()
    {
        if ($this->cuenta_contable_id) {
            $cuenta = CuentaContable::find($this->cuenta_contable_id);
            $this->cuenta_contable = $cuenta ? $cuenta->codigo : null;
        }
    }
}