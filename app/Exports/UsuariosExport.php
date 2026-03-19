<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuariosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $buscar;

    public function __construct($buscar = null)
    {
        $this->buscar = $buscar;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = User::whereNull('deleted_at');
        
        if ($this->buscar) {
            $query->buscar($this->buscar);
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'FOLIO',
            'EMPLEADO',
            'CORREO',
            'ROL',
            'ESTATUS',
            'FECHA CREACIÓN',
        ];
    }

    /**
    * @param mixed $usuario
    * @return array
    */
    public function map($usuario): array
    {
        return [
            $usuario->folio ?? '',
            $usuario->empleado ?? $usuario->name ?? '',
            $usuario->email ?? '',
            $usuario->rol ?? '',
            $usuario->estatus ?? '',
            $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : '',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la primera fila (encabezados)
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '083CAE']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
            ],
        ];
    }
}