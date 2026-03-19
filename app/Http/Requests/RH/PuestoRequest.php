<?php

namespace App\Http\Requests\RH;

use Illuminate\Foundation\Http\FormRequest;

class PuestoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'area_id' => 'nullable|exists:areas,id',
            'estatus' => 'required|in:Activo,Inactivo'
        ];

        if ($this->isMethod('POST')) {
            $rules['folio'] = 'required|string|unique:puestos,folio';
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $id = $this->route('id') ?? $this->route('puesto');
            if ($id && is_numeric($id)) {
                $rules['folio'] = 'required|string|unique:puestos,folio,' . $id;
            } else {
                $rules['folio'] = 'required|string|unique:puestos,folio';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'folio.required' => 'El folio es obligatorio',
            'folio.unique' => 'Este folio ya está registrado',
            'nombre.required' => 'El nombre del puesto es obligatorio',
            'area_id.exists' => 'El área seleccionada no es válida',
            'estatus.in' => 'El estatus debe ser Activo o Inactivo'
        ];
    }
}