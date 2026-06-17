<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignacionPersonalRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            'empleado_id' => 'required|exists:plantillas,plantilla_id',
            'proyecto_id' => 'required|exists:proyectos,id',
            'tipo_personal' => 'required|in:obrero,operador,supervisor,ingeniero,administrativo',
            'rol' => 'required|string|max:255',
            'fecha_asignacion' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_asignacion',
            'salario_diario' => 'required|numeric|min:0',
            'status' => 'nullable|in:activo,inactivo,vacaciones,permiso',
            'observaciones' => 'nullable|string'
        ];

        // Para actualización, hacer que los campos únicos excepto el actual
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // No hay campos únicos en esta tabla, pero mantenemos la estructura
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'empleado_id.required' => 'El empleado es obligatorio',
            'empleado_id.exists' => 'El empleado seleccionado no existe',
            'proyecto_id.required' => 'El proyecto es obligatorio',
            'proyecto_id.exists' => 'El proyecto seleccionado no existe',
            'tipo_personal.required' => 'El tipo de personal es obligatorio',
            'tipo_personal.in' => 'El tipo de personal seleccionado no es válido',
            'rol.required' => 'El rol es obligatorio',
            'rol.max' => 'El rol no debe exceder los 255 caracteres',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de asignación',
            'salario_diario.required' => 'El salario diario es obligatorio',
            'salario_diario.min' => 'El salario diario debe ser mayor a 0',
            'status.in' => 'El status seleccionado no es válido'
        ];
    }

    public function prepareForValidation()
    {
        // Si no hay fecha de asignación, usar la fecha actual
        if (!$this->fecha_asignacion) {
            $this->merge([
                'fecha_asignacion' => now()->format('Y-m-d')
            ]);
        }

        // Si no hay status, usar 'activo' por defecto
        if (!$this->status) {
            $this->merge([
                'status' => 'activo'
            ]);
        }
    }
}