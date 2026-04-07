<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar un proyecto de ejemplo
        DB::table('proyectos')->insert([
            'codigo' => 'PRO-2024-001',
            'nombre' => 'Torre Corporativa Reforma',
            'tipo_proyecto' => 'construccion',
            'categoria' => 'obra_nueva',
            'prioridad' => 'alta',
            'ubicacion' => 'Ciudad de México',
            'direccion' => 'Av. Reforma 123, Col. Juárez',
            'fecha_inicio' => '2024-06-01',
            'fecha_fin' => '2025-12-31',
            'descripcion' => 'Construcción de torre corporativa de 20 pisos',
            'estado' => 'activo',
            'moneda' => 'MXN',
            'tipo_cambio' => 1.0000,
            'cliente_nombre' => 'Grupo Reforma SA de CV',
            'cliente_rfc' => 'GRE840101ABC',
            'cliente_email' => 'contacto@gruporeforma.com',
            'cliente_telefono' => '5551234567',
            'cliente_contacto' => 'Juan Pérez',
            'cliente_cargo' => 'Director de Proyectos',
            'numero_contrato' => 'CON-2024-001',
            'fecha_firma' => '2024-05-15',
            'tipo_contrato' => 'precios_unitarios',
            'forma_pago' => 'anticipo',
            'plazo_pago' => 30,
            'responsable_id' => 1,
            'cargo_responsable' => 'Director de Proyectos',
            'email_responsable' => 'proyectos@empresa.com',
            'presupuesto_total' => 150000000.00,
            'anticipo' => 20.00,
            'margen' => 25.00,
            'fondo_reserva' => 5000000.00,
            'status' => 'activo',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}