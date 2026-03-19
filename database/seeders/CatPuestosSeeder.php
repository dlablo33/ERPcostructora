<?php

namespace Database\Seeders;

use App\Models\CatArea;
use App\Models\CatPuesto;
use Illuminate\Database\Seeder;

class CatPuestosSeeder extends Seeder
{
    public function run(): void
    {
        $areas = CatArea::all()->keyBy('area');
        
        $puestos = [
            // Dirección General
            ['puesto' => 'Director General', 'descripcion' => 'Responsable de la dirección general de la empresa', 'area' => 'Dirección General'],
            ['puesto' => 'Director de Operaciones', 'descripcion' => 'Responsable de las operaciones de la empresa', 'area' => 'Dirección General'],
            ['puesto' => 'Director Administrativo', 'descripcion' => 'Responsable de la administración de la empresa', 'area' => 'Dirección General'],
            
            // Administración
            ['puesto' => 'Gerente Administrativo', 'descripcion' => 'Responsable de la gestión administrativa', 'area' => 'Administración'],
            ['puesto' => 'Auxiliar Administrativo', 'descripcion' => 'Apoyo en tareas administrativas', 'area' => 'Administración'],
            ['puesto' => 'Recepcionista', 'descripcion' => 'Atención telefónica y recepción de visitantes', 'area' => 'Administración'],
            
            // Contabilidad
            ['puesto' => 'Contador General', 'descripcion' => 'Responsable de la contabilidad general', 'area' => 'Contabilidad'],
            ['puesto' => 'Auxiliar Contable', 'descripcion' => 'Apoyo en registro contable', 'area' => 'Contabilidad'],
            ['puesto' => 'Analista Fiscal', 'descripcion' => 'Responsable de declaraciones fiscales', 'area' => 'Contabilidad'],
            ['puesto' => 'Cuentas por Pagar', 'descripcion' => 'Gestión de cuentas por pagar', 'area' => 'Contabilidad'],
            ['puesto' => 'Cuentas por Cobrar', 'descripcion' => 'Gestión de cuentas por cobrar', 'area' => 'Contabilidad'],
            
            // Recursos Humanos
            ['puesto' => 'Gerente de RH', 'descripcion' => 'Responsable de recursos humanos', 'area' => 'Recursos Humanos'],
            ['puesto' => 'Coordinador de RH', 'descripcion' => 'Coordinación de actividades de RH', 'area' => 'Recursos Humanos'],
            ['puesto' => 'Analista de RH', 'descripcion' => 'Análisis de procesos de RH', 'area' => 'Recursos Humanos'],
            ['puesto' => 'Reclutador', 'descripcion' => 'Responsable de reclutamiento y selección', 'area' => 'Recursos Humanos'],
            ['puesto' => 'Especialista en Nómina', 'descripcion' => 'Cálculo y administración de nómina', 'area' => 'Recursos Humanos'],
            
            // Operaciones
            ['puesto' => 'Gerente de Operaciones', 'descripcion' => 'Responsable de las operaciones', 'area' => 'Operaciones'],
            ['puesto' => 'Supervisor de Obra', 'descripcion' => 'Supervisión de obras en campo', 'area' => 'Operaciones'],
            ['puesto' => 'Residente de Obra', 'descripcion' => 'Residencia de obras', 'area' => 'Operaciones'],
            ['puesto' => 'Coordinador de Obra', 'descripcion' => 'Coordinación de actividades de obra', 'area' => 'Operaciones'],
            
            // Proyectos
            ['puesto' => 'Gerente de Proyectos', 'descripcion' => 'Responsable de la gestión de proyectos', 'area' => 'Proyectos'],
            ['puesto' => 'Coordinador de Proyectos', 'descripcion' => 'Coordinación de proyectos', 'area' => 'Proyectos'],
            ['puesto' => 'Project Manager', 'descripcion' => 'Gestión de proyectos específicos', 'area' => 'Proyectos'],
            
            // Compras
            ['puesto' => 'Gerente de Compras', 'descripcion' => 'Responsable de las compras', 'area' => 'Compras'],
            ['puesto' => 'Analista de Compras', 'descripcion' => 'Análisis y gestión de compras', 'area' => 'Compras'],
            ['puesto' => 'Auxiliar de Compras', 'descripcion' => 'Apoyo en el área de compras', 'area' => 'Compras'],
            
            // Almacén
            ['puesto' => 'Jefe de Almacén', 'descripcion' => 'Responsable del almacén', 'area' => 'Almacén'],
            ['puesto' => 'Almacenista', 'descripcion' => 'Gestión de inventarios y materiales', 'area' => 'Almacén'],
            ['puesto' => 'Auxiliar de Almacén', 'descripcion' => 'Apoyo en actividades de almacén', 'area' => 'Almacén'],
            
            // Mantenimiento
            ['puesto' => 'Jefe de Mantenimiento', 'descripcion' => 'Responsable del mantenimiento', 'area' => 'Mantenimiento'],
            ['puesto' => 'Técnico de Mantenimiento', 'descripcion' => 'Ejecución de mantenimiento', 'area' => 'Mantenimiento'],
            ['puesto' => 'Mecánico', 'descripcion' => 'Reparación y mantenimiento mecánico', 'area' => 'Mantenimiento'],
            ['puesto' => 'Electricista', 'descripcion' => 'Instalaciones y reparaciones eléctricas', 'area' => 'Mantenimiento'],
            
            // Seguridad e Higiene
            ['puesto' => 'Coordinador de Seguridad', 'descripcion' => 'Responsable de seguridad e higiene', 'area' => 'Seguridad e Higiene'],
            ['puesto' => 'Supervisor de Seguridad', 'descripcion' => 'Supervisión de medidas de seguridad', 'area' => 'Seguridad e Higiene'],
            
            // Sistemas
            ['puesto' => 'Gerente de Sistemas', 'descripcion' => 'Responsable de sistemas', 'area' => 'Sistemas'],
            ['puesto' => 'Desarrollador', 'descripcion' => 'Desarrollo de software', 'area' => 'Sistemas'],
            ['puesto' => 'Soporte Técnico', 'descripcion' => 'Soporte a usuarios', 'area' => 'Sistemas'],
            ['puesto' => 'Administrador de Redes', 'descripcion' => 'Administración de redes', 'area' => 'Sistemas'],
            
            // Calidad
            ['puesto' => 'Coordinador de Calidad', 'descripcion' => 'Responsable de calidad', 'area' => 'Calidad'],
            ['puesto' => 'Inspector de Calidad', 'descripcion' => 'Inspección de calidad', 'area' => 'Calidad'],
            
            // Flotilla
            ['puesto' => 'Coordinador de Flotilla', 'descripcion' => 'Responsable de la flotilla', 'area' => 'Flotilla'],
            ['puesto' => 'Operador de Unidad', 'descripcion' => 'Conductor de unidades', 'area' => 'Flotilla'],
            
            // Jurídico
            ['puesto' => 'Abogado', 'descripcion' => 'Asesoría legal', 'area' => 'Jurídico'],
            
            // Mercadotecnia
            ['puesto' => 'Coordinador de Marketing', 'descripcion' => 'Responsable de marketing', 'area' => 'Mercadotecnia'],
            ['puesto' => 'Diseñador Gráfico', 'descripcion' => 'Diseño de materiales gráficos', 'area' => 'Mercadotecnia'],
            
            // Ventas
            ['puesto' => 'Gerente de Ventas', 'descripcion' => 'Responsable de ventas', 'area' => 'Ventas'],
            ['puesto' => 'Ejecutivo de Ventas', 'descripcion' => 'Ventas y atención a clientes', 'area' => 'Ventas'],
        ];

        foreach ($puestos as $puesto) {
            if (isset($areas[$puesto['area']])) {
                CatPuesto::updateOrCreate(
                    ['puesto' => $puesto['puesto']],
                    [
                        'puesto' => $puesto['puesto'],
                        'descripcion' => $puesto['descripcion'],
                        'cat_area_id' => $areas[$puesto['area']]->cat_area_id,
                        'activo' => true
                    ]
                );
            }
        }
    }
}