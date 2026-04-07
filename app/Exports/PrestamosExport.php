<?php

namespace App\Exports;  // <-- IMPORTANTE: Este debe ser EXACTAMENTE App\Exports

use App\Models\Prestamo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PrestamosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Prestamo::with('empleado')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Folio',
            'Estatus',
            'Fecha Inicio',
            'Empleado',
            'Motivo',
            'Monto',
            'Monto Descuento',
            'Número Pagos',
            'Frecuencia',
            'Monto Restante',
            'Observaciones',
            'Gasto',
            'Fecha Registro'
        ];
    }

    public function map($prestamo): array
    {
        return [
            $prestamo->id,
            $prestamo->folio,
            $prestamo->estatus,
            $prestamo->fecha_inicio->format('d/m/Y'),
            $prestamo->nombre_empleado,
            $prestamo->motivo,
            number_format($prestamo->monto, 2),
            number_format($prestamo->monto_descuento, 2),
            $prestamo->numero_pagos,
            $prestamo->frecuencia,
            number_format($prestamo->monto_restante, 2),
            $prestamo->observaciones ?? '-',
            $prestamo->gasto ?? '-',
            $prestamo->created_at->format('d/m/Y H:i')
        ];
    }
}