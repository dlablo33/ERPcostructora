<?php

namespace App\Http\Requests;

use App\Models\AnalisisPrecioUnitario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class APURequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta petición.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Reglas de validación.
     *
     * Nota: usamos AnalisisPrecioUnitario::class en lugar de un string
     * para que Laravel resuelva el nombre de la tabla desde el modelo
     * (analisis_precios_unitarios) automáticamente.
     */
    public function rules(): array
    {
        $apuId = $this->route('apu') ?? $this->route('id');

        return [
            'codigo' => [
                'required',
                'string',
                'max:50',
                $apuId
                    ? Rule::unique(AnalisisPrecioUnitario::class, 'codigo')->ignore($apuId)
                    : Rule::unique(AnalisisPrecioUnitario::class, 'codigo'),
            ],
            'concepto'   => 'required|string|max:500',
            'categoria'  => 'required|in:materiales,mano_obra,maquinaria,subcontratos,indirectos',
            'unidad'     => 'required|string|max:20',

            'costo_materiales'   => 'nullable|numeric|min:0',
            'costo_mano_obra'    => 'nullable|numeric|min:0',
            'costo_maquinaria'   => 'nullable|numeric|min:0',
            'costo_subcontratos' => 'nullable|numeric|min:0',

            'estado'        => 'nullable|in:activo,revision,inactivo',
            'observaciones' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'codigo.required'    => 'El código es obligatorio.',
            'codigo.unique'      => 'Ya existe un APU con ese código.',
            'codigo.max'         => 'El código no puede tener más de 50 caracteres.',

            'concepto.required'  => 'El concepto es obligatorio.',
            'concepto.max'       => 'El concepto no puede tener más de 500 caracteres.',

            'categoria.required' => 'Debes seleccionar una categoría.',
            'categoria.in'       => 'La categoría seleccionada no es válida.',

            'unidad.required'    => 'La unidad de medida es obligatoria.',
            'unidad.max'         => 'La unidad no puede tener más de 20 caracteres.',

            'costo_materiales.numeric'   => 'El costo de materiales debe ser un número.',
            'costo_materiales.min'       => 'El costo de materiales no puede ser negativo.',
            'costo_mano_obra.numeric'    => 'El costo de mano de obra debe ser un número.',
            'costo_mano_obra.min'        => 'El costo de mano de obra no puede ser negativo.',
            'costo_maquinaria.numeric'   => 'El costo de maquinaria debe ser un número.',
            'costo_maquinaria.min'       => 'El costo de maquinaria no puede ser negativo.',
            'costo_subcontratos.numeric' => 'El costo de subcontratos debe ser un número.',
            'costo_subcontratos.min'     => 'El costo de subcontratos no puede ser negativo.',

            'estado.in'         => 'El estado seleccionado no es válido.',
            'observaciones.max' => 'Las observaciones no pueden tener más de 2000 caracteres.',
        ];
    }

    /**
     * Nombres amigables de los atributos.
     */
    public function attributes(): array
    {
        return [
            'codigo'             => 'código',
            'concepto'           => 'concepto',
            'categoria'          => 'categoría',
            'unidad'             => 'unidad de medida',
            'costo_materiales'   => 'costo de materiales',
            'costo_mano_obra'    => 'costo de mano de obra',
            'costo_maquinaria'   => 'costo de maquinaria',
            'costo_subcontratos' => 'costo de subcontratos',
            'estado'             => 'estado',
            'observaciones'      => 'observaciones',
        ];
    }

    /**
     * Normaliza los datos antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo'             => $this->codigo ? strtoupper(trim($this->codigo)) : null,
            'concepto'           => $this->concepto ? trim($this->concepto) : null,
            'unidad'             => $this->unidad ? trim($this->unidad) : null,
            'costo_materiales'   => $this->costo_materiales ?? 0,
            'costo_mano_obra'    => $this->costo_mano_obra ?? 0,
            'costo_maquinaria'   => $this->costo_maquinaria ?? 0,
            'costo_subcontratos' => $this->costo_subcontratos ?? 0,
            'estado'             => $this->estado ?: 'activo',
        ]);
    }
}