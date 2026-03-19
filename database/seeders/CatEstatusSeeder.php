<?php

namespace Database\Seeders;

use App\Models\CatEstatus;
use Illuminate\Database\Seeder;

class CatEstatusSeeder extends Seeder
{
    public function run(): void
    {
        $estatus = [
            // Estatus para empleados
            ['estatus' => 'Activo', 'clave' => 'Activo', 'tipo' => 'empleado', 'color' => '#28a745', 'orden' => 1],
            ['estatus' => 'Inactivo', 'clave' => 'Inactivo', 'tipo' => 'empleado', 'color' => '#6c757d', 'orden' => 2],
            ['estatus' => 'Vacaciones', 'clave' => 'Vacaciones', 'tipo' => 'empleado', 'color' => '#ffc107', 'orden' => 3],
            ['estatus' => 'Baja', 'clave' => 'Baja', 'tipo' => 'empleado', 'color' => '#dc3545', 'orden' => 4],
            ['estatus' => 'Incapacidad', 'clave' => 'Incapacidad', 'tipo' => 'empleado', 'color' => '#fd7e14', 'orden' => 5],
            ['estatus' => 'Permiso', 'clave' => 'Permiso', 'tipo' => 'empleado', 'color' => '#20c997', 'orden' => 6],
            
            // Estatus para documentos
            ['estatus' => 'Vigente', 'clave' => 'Vigente', 'tipo' => 'documento', 'color' => '#28a745', 'orden' => 1],
            ['estatus' => 'Por Vencer', 'clave' => 'Por Vencer', 'tipo' => 'documento', 'color' => '#ffc107', 'orden' => 2],
            ['estatus' => 'Vencido', 'clave' => 'Vencido', 'tipo' => 'documento', 'color' => '#dc3545', 'orden' => 3],
            ['estatus' => 'Sin Documento', 'clave' => 'Sin Documento', 'tipo' => 'documento', 'color' => '#6c757d', 'orden' => 4],
            
            // Estatus para unidades
            ['estatus' => 'Disponible', 'clave' => 'Disponible', 'tipo' => 'unidad', 'color' => '#28a745', 'orden' => 1],
            ['estatus' => 'En Ruta', 'clave' => 'En Ruta', 'tipo' => 'unidad', 'color' => '#007bff', 'orden' => 2],
            ['estatus' => 'En Mantenimiento', 'clave' => 'Mantenimiento', 'tipo' => 'unidad', 'color' => '#ffc107', 'orden' => 3],
            ['estatus' => 'Fuera de Servicio', 'clave' => 'FueraServicio', 'tipo' => 'unidad', 'color' => '#dc3545', 'orden' => 4],
        ];

        foreach ($estatus as $est) {
            CatEstatus::updateOrCreate(
                ['clave' => $est['clave']],
                $est
            );
        }
    }
}