<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoDocumento extends Model
{
    use HasFactory;

    protected $table = 'empleado_documentos';

    protected $fillable = [
        'plantilla_id',
        'nombre_documento',
        'archivo',
        'tipo_archivo',
        'tamanio'
    ];

    protected $casts = [
        'tamanio' => 'integer'
    ];

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id', 'plantilla_id');
    }
}