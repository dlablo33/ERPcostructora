<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporteFotograficoRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            'proyecto_id' => 'required|exists:proyectos,id',
            'categoria' => 'required|in:avance,calidad,seguridad,reunion,entrega,instalaciones,estructura,terracerias,pavimentos',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'nullable|date',
            'responsable_id' => 'nullable|exists:users,id',
            'empleado_id' => 'nullable|exists:plantillas,plantilla_id',
            'observaciones' => 'nullable|string',
            'estado' => 'nullable|in:activo,archivado'
        ];

        // Para creación (subida de archivos)
        if ($this->isMethod('POST')) {
            $rules['archivo'] = 'nullable|file|image|max:10240|mimes:jpeg,png,gif,webp';
            $rules['archivos'] = 'nullable|array';
            $rules['archivos.*'] = 'file|image|max:10240|mimes:jpeg,png,gif,webp';
            
            // Al menos uno de los dos debe estar presente
            $rules['archivo'] = 'required_without:archivos|nullable|file|image|max:10240|mimes:jpeg,png,gif,webp';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'proyecto_id.required' => 'El proyecto es obligatorio',
            'proyecto_id.exists' => 'El proyecto seleccionado no existe',
            'categoria.required' => 'La categoría es obligatoria',
            'categoria.in' => 'La categoría seleccionada no es válida',
            'archivo.required_without' => 'Debe seleccionar al menos una foto',
            'archivo.image' => 'El archivo debe ser una imagen',
            'archivo.max' => 'La imagen no debe exceder los 10MB',
            'archivo.mimes' => 'Solo se permiten archivos JPEG, PNG, GIF o WEBP',
            'archivos.*.image' => 'El archivo debe ser una imagen',
            'archivos.*.max' => 'La imagen no debe exceder los 10MB',
            'archivos.*.mimes' => 'Solo se permiten archivos JPEG, PNG, GIF o WEBP',
            'fecha.date' => 'La fecha debe ser una fecha válida',
            'responsable_id.exists' => 'El responsable seleccionado no existe',
            'empleado_id.exists' => 'El empleado seleccionado no existe',
            'estado.in' => 'El estado seleccionado no es válido'
        ];
    }

    public function prepareForValidation()
    {
        // Si no hay fecha, usar la fecha actual
        if (!$this->fecha) {
            $this->merge([
                'fecha' => now()->format('Y-m-d')
            ]);
        }

        // Si no hay categoría, usar 'avance' por defecto
        if (!$this->categoria) {
            $this->merge([
                'categoria' => 'avance'
            ]);
        }
    }
}