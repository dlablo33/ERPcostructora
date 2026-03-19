<?php

namespace App\Http\Requests\RH;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'empleado' => 'nullable|string|max:255',
            'rol' => 'required|string|max:100',
            'estatus' => 'required|in:Activo,Inactivo',
        ];

        // Para creación (POST)
        if ($this->isMethod('POST')) {
            $rules['folio'] = 'required|string|unique:users,folio';
            $rules['email'] = 'required|string|email|max:255|unique:users,email';
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        // Para actualización (PUT/PATCH)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // Obtener el ID de diferentes maneras
            $id = null;
            
            if ($this->route('id')) {
                $id = $this->route('id');
            } elseif ($this->route('user')) {
                $id = $this->route('user');
            } elseif ($this->input('id')) {
                $id = $this->input('id');
            }
            
            if (!$id) {
                $path = $this->path();
                $segments = explode('/', $path);
                $lastSegment = end($segments);
                if (is_numeric($lastSegment)) {
                    $id = $lastSegment;
                }
            }
            
            \Log::info('=== USERREQUEST DEBUG ===');
            \Log::info('ID encontrado: ' . ($id ?? 'null'));
            
            $rules['folio'] = 'required|string|unique:users,folio,' . $id;
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $id;
            
            // La contraseña es opcional en actualización
            $rules['password'] = ['nullable', 'confirmed', Password::min(8)];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'folio.required' => 'El folio es obligatorio',
            'folio.unique' => 'Este folio ya está registrado',
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo es obligatorio',
            'email.unique' => 'Este correo ya está registrado',
            'email.email' => 'Ingrese un correo válido',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'rol.required' => 'El rol es obligatorio',
            'estatus.in' => 'El estatus debe ser Activo o Inactivo'
        ];
    }
}