<?php

namespace App\Http\Requests\RH;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'documentos' => 'array',
            'documentos.*.nombre' => 'required|string|max:255',
            'documentos.*.archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ];
    }

    public function messages(): array
    {
        return [
            'documentos.*.nombre.required' => 'El nombre del documento es requerido',
            'documentos.*.archivo.mimes' => 'El archivo debe ser PDF, JPG o PNG',
            'documentos.*.archivo.max' => 'El archivo no debe exceder los 5MB',
        ];
    }
}