<?php

namespace App\Http\Requests\RH;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
            'cuenta_contable' => 'nullable|string|max:50'
        ];

        // Para creación (POST)
        if ($this->isMethod('POST')) {
            $rules['folio'] = 'required|string|unique:areas,folio';
            \Log::info('AreaRequest: Es POST, regla unique sin ID');
        }

        // Para actualización (PUT/PATCH)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // Obtener el ID de diferentes maneras
            $id = null;
            
            if ($this->route('id')) {
                $id = $this->route('id');
                \Log::info('ID obtenido de route("id"): ' . $id);
            } elseif ($this->route('area')) {
                $id = $this->route('area');
                \Log::info('ID obtenido de route("area"): ' . $id);
            } elseif ($this->input('id')) {
                $id = $this->input('id');
                \Log::info('ID obtenido de input("id"): ' . $id);
            }
            
            if (!$id) {
                $path = $this->path();
                $segments = explode('/', $path);
                $lastSegment = end($segments);
                
                if (is_numeric($lastSegment)) {
                    $id = $lastSegment;
                    \Log::info('ID extraído de URL: ' . $id);
                }
            }
            
            \Log::info('=== AREAREQUEST DEBUG ===');
            \Log::info('Método: ' . $this->method());
            \Log::info('URL: ' . $this->fullUrl());
            \Log::info('ID final: ' . ($id ?? 'null'));
            
            if ($id && is_numeric($id)) {
                $id = (int) $id;
                $rules['folio'] = 'required|string|unique:areas,folio,' . $id;
                \Log::info('Regla unique aplicada con ID: ' . $id);
            } else {
                $rules['folio'] = 'required|string|unique:areas,folio';
                \Log::warning('No se encontró ID válido, usando unique sin excluir');
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'folio.required' => 'El folio es obligatorio',
            'folio.unique' => 'Este folio ya está registrado',
            'nombre.required' => 'El nombre del área es obligatorio'
        ];
    }
}