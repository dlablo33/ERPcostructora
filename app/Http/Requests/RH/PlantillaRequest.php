<?php

namespace App\Http\Requests\RH;

use Illuminate\Foundation\Http\FormRequest;

class PlantillaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'correo' => 'nullable|email|max:255',
            'celular' => 'nullable|string|max:20',
            'numero_seguro_social' => 'nullable|string|max:50',
            'rfc' => 'nullable|string|max:20',
            'curp' => 'nullable|string|max:20',
            'alias' => 'nullable|string|max:255',
            'calle' => 'nullable|string|max:255',
            'num_exterior' => 'nullable|string|max:20',
            'num_interior' => 'nullable|string|max:20',
            'satcat_codigos_postales_codigo_postal' => 'nullable|string|max:10',
            'cat_area_id' => 'nullable|integer',
            'cat_puesto_id' => 'nullable|integer',
            'sueldo' => 'nullable|numeric|min:0',
            'fecha_ingreso' => 'nullable|date',
            'operador' => 'nullable|boolean',
            'numero_licencia' => 'nullable|string|max:100',
            'vencimiento_licencia' => 'nullable|date',
            'contacto_emergencia' => 'nullable|string|max:255',
            'numero_emergencia' => 'nullable|string|max:20',
            'estatus' => 'nullable|string|max:50',
            'numero_empleado_interno' => 'nullable|string|max:50|unique:plantillas,numero_empleado_interno',
            'aplica_asistencia' => 'nullable|boolean',
            'reserva' => 'nullable|boolean',
        ];

        // Para creación (POST)
        if ($this->isMethod('POST')) {
            // Validaciones específicas para creación
        }

        // Para actualización (PUT/PATCH)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $id = $this->route('id') ?? $this->route('plantilla');
            
            // Si existe ID, permitir actualización
            if ($id && is_numeric($id)) {
                $rules['numero_empleado_interno'] = 'nullable|string|max:50|unique:plantillas,numero_empleado_interno,' . $id . ',plantilla_id';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'correo.email' => 'El correo debe ser válido',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida',
            'vencimiento_licencia.date' => 'El vencimiento de licencia debe ser una fecha válida',
            'sueldo.numeric' => 'El sueldo debe ser un número',
            'sueldo.min' => 'El sueldo no puede ser negativo',
            'numero_empleado_interno.unique' => 'Este número de empleado ya está registrado',
        ];
    }
}