<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostoDirectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // Reglas para crear (POST)
        if ($this->isMethod('post')) {
            return [
                'proyecto_id'      => 'required|exists:proyectos,id',
                'categoria'        => 'required|string|in:materiales,mano_obra,maquinaria,subcontratos,equipos,otros',
                'concepto'         => 'required|string|max:255',
                'fecha'            => 'required|date',

                'proveedor_id'     => 'nullable|exists:proveedores,id',
                'empleado_id'      => 'nullable|exists:plantilla,plantilla_id',
                'proveedor_nombre' => 'nullable|string|max:255',
                'rfc'              => 'nullable|string|max:20',
                'factura'          => 'nullable|string|max:100',
                'descripcion'      => 'nullable|string',
                'unidad'           => 'nullable|string|max:50',
                'cantidad'         => 'nullable|numeric|min:0',
                'precio_unitario'  => 'nullable|numeric|min:0',
                'iva'              => 'nullable|numeric|min:0',
                'fecha_pago'       => 'nullable|date',
                'estatus_pago'     => 'nullable|in:pendiente,pagado,programado,vencido',
                'observaciones'    => 'nullable|string',

                'documentos'       => 'nullable|array',
                'documentos.*'     => 'file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
            ];
        }

        // Reglas para actualizar (PUT/PATCH) - iguales pero sin required estricto
        return [
            'proyecto_id'      => 'sometimes|required|exists:proyectos,id',
            'categoria'        => 'sometimes|required|string|in:materiales,mano_obra,maquinaria,subcontratos,equipos,otros',
            'concepto'         => 'sometimes|required|string|max:255',
            'fecha'            => 'sometimes|required|date',

            'proveedor_id'     => 'nullable|exists:proveedores,id',
            'empleado_id'      => 'nullable|exists:plantilla,plantilla_id',
            'proveedor_nombre' => 'nullable|string|max:255',
            'rfc'              => 'nullable|string|max:20',
            'factura'          => 'nullable|string|max:100',
            'descripcion'      => 'nullable|string',
            'unidad'           => 'nullable|string|max:50',
            'cantidad'         => 'nullable|numeric|min:0',
            'precio_unitario'  => 'nullable|numeric|min:0',
            'iva'              => 'nullable|numeric|min:0',
            'fecha_pago'       => 'nullable|date',
            'estatus_pago'     => 'nullable|in:pendiente,pagado,programado,vencido',
            'observaciones'    => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'proyecto_id.required' => 'Debes seleccionar un proyecto.',
            'proyecto_id.exists'   => 'El proyecto seleccionado no existe.',
            'categoria.required'   => 'La categoría es obligatoria.',
            'categoria.in'         => 'La categoría seleccionada no es válida.',
            'concepto.required'    => 'El concepto es obligatorio.',
            'fecha.required'       => 'La fecha es obligatoria.',
            'monto.required'       => 'El monto es obligatorio.',
        ];
    }
}