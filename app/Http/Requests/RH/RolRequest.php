<?php

namespace App\Http\Requests\RH;

use Illuminate\Foundation\Http\FormRequest;

class RolRequest extends FormRequest
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
            'estatus' => 'required|in:Activo,Inactivo'
        ];

        // Si es creación (POST)
        if ($this->isMethod('POST')) {
            $rules['folio'] = 'required|string|unique:roles,folio';
            \Log::info('RolRequest: Es POST, regla unique sin ID');
        }

        // Si es actualización (PUT/PATCH)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // Obtener el ID de diferentes maneras
            $id = null;
            
            // Intentar obtener de la ruta
            if ($this->route('id')) {
                $id = $this->route('id');
                \Log::info('ID obtenido de route("id"): ' . $id);
            } elseif ($this->route('rol')) {
                $id = $this->route('rol');
                \Log::info('ID obtenido de route("rol"): ' . $id);
            } elseif ($this->input('id')) {
                $id = $this->input('id');
                \Log::info('ID obtenido de input("id"): ' . $id);
            }
            
            // Si aún no tenemos ID, intentar extraer de la URL
            if (!$id) {
                $path = $this->path();
                $segments = explode('/', $path);
                $lastSegment = end($segments);
                
                if (is_numeric($lastSegment)) {
                    $id = $lastSegment;
                    \Log::info('ID extraído de URL (último segmento): ' . $id);
                }
            }
            
            // Logs de depuración
            \Log::info('=== ROLREQUEST DEBUG ===');
            \Log::info('Método: ' . $this->method());
            \Log::info('URL completa: ' . $this->fullUrl());
            \Log::info('Path: ' . $this->path());
            \Log::info('ID encontrado: ' . ($id ?? 'null'));
            \Log::info('Tipo de ID: ' . gettype($id));
            
            // Aplicar la regla unique con el ID si existe
            if ($id && is_numeric($id)) {
                $id = (int) $id; // Asegurar que sea entero
                $rules['folio'] = 'required|string|unique:roles,folio,' . $id;
                \Log::info('Regla unique aplicada con ID: ' . $id);
            } else {
                // Si no hay ID, tratamos como creación
                $rules['folio'] = 'required|string|unique:roles,folio';
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
            'nombre.required' => 'El nombre del rol es obligatorio',
            'estatus.in' => 'El estatus debe ser Activo o Inactivo'
        ];
    }
}