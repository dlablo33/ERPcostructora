<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostoIndirectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'proyecto_id'   => 'required|exists:proyectos,id',
            'categoria'     => 'required|in:personal_tecnico,administracion,seguridad,servicios,herramienta',
            'concepto'      => 'required|string|max:255',
            'fecha'         => 'required|date',
            'proveedor_id'  => 'nullable|exists:proveedores,id',
            'rfc'           => 'nullable|string|max:13',
            'factura'       => 'nullable|string|max:50',
            'descripcion'   => 'nullable|string',
            'subtotal'      => 'required|numeric|min:0',
            'iva'           => 'nullable|numeric|min:0',
            'forma_pago'    => 'nullable|in:transferencia,cheque,efectivo,tarjeta',
            'fecha_pago'    => 'nullable|date',
            'estatus_pago'  => 'nullable|in:pagado,pendiente,programado,vencido',
            'observaciones' => 'nullable|string',
        ];
    }
}