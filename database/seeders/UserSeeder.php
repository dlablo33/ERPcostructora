<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $usuarios = [
            [
                'folio' => 'USR-001',
                'name' => 'JUAN CARLOS PÉREZ LÓPEZ',
                'email' => 'juan.perez@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'JUAN CARLOS PÉREZ LÓPEZ',
                'rol' => 'Administrador',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-002',
                'name' => 'MARÍA FERNANDA RAMOS GARCÍA',
                'email' => 'maria.ramos@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'MARÍA FERNANDA RAMOS GARCÍA',
                'rol' => 'Gerente de Proyectos',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-003',
                'name' => 'CARLOS ALBERTO MENDOZA SÁNCHEZ',
                'email' => 'carlos.mendoza@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'CARLOS ALBERTO MENDOZA SÁNCHEZ',
                'rol' => 'Supervisor de Obra',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-004',
                'name' => 'ANA SOFÍA MARTÍNEZ FLORES',
                'email' => 'ana.martinez@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'ANA SOFÍA MARTÍNEZ FLORES',
                'rol' => 'Residente de Obra',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-005',
                'name' => 'ROBERTO ANTONIO SÁNCHEZ TORRES',
                'email' => 'roberto.sanchez@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'ROBERTO ANTONIO SÁNCHEZ TORRES',
                'rol' => 'Almacenista',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-006',
                'name' => 'LAURA PATRICIA FLORES GONZÁLEZ',
                'email' => 'laura.flores@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'LAURA PATRICIA FLORES GONZÁLEZ',
                'rol' => 'Recursos Humanos',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-007',
                'name' => 'JOSÉ LUIS TORRES RAMÍREZ',
                'email' => 'jose.torres@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'JOSÉ LUIS TORRES RAMÍREZ',
                'rol' => 'Finanzas',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-008',
                'name' => 'PATRICIA ELIZABETH CASTILLO VEGA',
                'email' => 'patricia.castillo@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'PATRICIA ELIZABETH CASTILLO VEGA',
                'rol' => 'Compras',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-009',
                'name' => 'MIGUEL ÁNGEL HERRERA DÍAZ',
                'email' => 'miguel.herrera@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'MIGUEL ÁNGEL HERRERA DÍAZ',
                'rol' => 'Operador de Maquinaria',
                'estatus' => 'Inactivo'
            ],
            [
                'folio' => 'USR-010',
                'name' => 'FERNANDO GONZÁLEZ MARTÍNEZ',
                'email' => 'fernando.gonzalez@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'FERNANDO GONZÁLEZ MARTÍNEZ',
                'rol' => 'Sistemas',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-011',
                'name' => 'GABRIELA ALEJANDRA NAVARRO',
                'email' => 'gabriela.navarro@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'GABRIELA ALEJANDRA NAVARRO',
                'rol' => 'Calidad',
                'estatus' => 'Activo'
            ],
            [
                'folio' => 'USR-012',
                'name' => 'ALEJANDRO GUZMÁN REYES',
                'email' => 'alejandro.guzman@empresa.com',
                'password' => Hash::make('password123'),
                'empleado' => 'ALEJANDRO GUZMÁN REYES',
                'rol' => 'Seguridad e Higiene',
                'estatus' => 'Inactivo'
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}