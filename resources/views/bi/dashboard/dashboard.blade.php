@extends('layouts.navigation')
@section('content')
<!-- Contenido principal con padding-top para compensar el navbar fijo -->
<div class="min-h-screen bg-gray-50 text-gray-800 pt-16">
    <!-- Main Dashboard Content -->
    <main class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6 fade-in">
        
        <!-- Dashboard Header con Información Personalizada -->
        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6">
                <div>
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-800 to-green-600 flex items-center justify-center">
                            <span class="text-2xl font-bold text-white">JM</span>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900">Dashboard Directivo</h1>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-lg text-gray-600">Bienvenido, <span class="font-semibold text-blue-800">{{ Auth::user()->name ?? 'Ing. Juan Martínez' }}</span></span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Director General</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 max-w-3xl text-base">Vista consolidada de operaciones, finanzas y desempeño de proyectos - Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex gap-3">
                        <div class="relative">
                            <select class="appearance-none bg-white border border-gray-300 rounded-lg py-3 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 shadow-sm text-base">
                                <option>Últimos 30 días</option>
                                <option>Últimos 90 días</option>
                                <option>Este trimestre</option>
                                <option>Este año</option>
                                <option>Año anterior</option>
                                <option>Período personalizado</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <button class="bg-blue-800 hover:bg-blue-900 text-white px-5 py-3 rounded-lg flex items-center transition-all duration-200 shadow-md hover:shadow-lg text-base">
                                <i class="fas fa-download mr-2"></i> Exportar PDF
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg flex items-center transition-all duration-200 shadow-md hover:shadow-lg text-base">
                                <i class="fas fa-sync-alt mr-2"></i> Organizacion 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats Ribbon -->
            <div class="mt-8 flex flex-wrap gap-3">
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Proyectos Activos</p>
                            <p class="text-2xl font-bold text-gray-900">28</p>
                        </div>
                        <i class="fas fa-award text-3xl text-blue-800 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Proyectos Completados</p>
                            <p class="text-2xl font-bold text-gray-900">142</p>
                        </div>
                        <i class="fas fa-hard-hat text-3xl text-green-600 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Equipo a Cargo</p>
                            <p class="text-2xl font-bold text-gray-900">347</p>
                        </div>
                        <i class="fas fa-users text-3xl text-blue-800 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Certificaciones</p>
                            <p class="text-2xl font-bold text-gray-900">18</p>
                        </div>
                        <i class="fas fa-certificate text-3xl text-green-600 opacity-70"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- NUEVA SECCIÓN: Tablas Financieras -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <!-- Tabla de Cuentas por Cobrar -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Cuentas por Cobrar</h3>
                            <p class="text-gray-600 text-sm">Total pendiente: $4,850,250</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition-colors duration-200">
                                <i class="fas fa-file-export mr-1"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Cliente</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Vencimiento</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Monto</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $cuentasCobrar = [
                                    ['cliente' => 'Constructora Alta Vista', 'vencimiento' => '15/03/2024', 'monto' => '$1,250,000', 'estado' => 'Pendiente'],
                                    ['cliente' => 'Inmobiliaria Diamante', 'vencimiento' => '22/03/2024', 'monto' => '$850,000', 'estado' => 'Vencido'],
                                    ['cliente' => 'Desarrolladora del Norte', 'vencimiento' => '05/04/2024', 'monto' => '$2,150,000', 'estado' => 'Pendiente'],
                                    ['cliente' => 'Grupo Inmobiliario Sur', 'vencimiento' => '12/03/2024', 'monto' => '$350,000', 'estado' => 'Pagado'],
                                    ['cliente' => 'Corporación Urbana', 'vencimiento' => '28/03/2024', 'monto' => '$250,250', 'estado' => 'Pendiente'],
                                ];
                            @endphp
                            @foreach($cuentasCobrar as $cuenta)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 text-base">{{ $cuenta['cliente'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm text-gray-900">{{ $cuenta['vencimiento'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 text-base">{{ $cuenta['monto'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $estadoColors = [
                                            'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'Vencido' => 'bg-red-100 text-red-800',
                                            'Pagado' => 'bg-green-100 text-green-800'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $estadoColors[$cuenta['estado']] }}">
                                        {{ $cuenta['estado'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Mostrando {{ count($cuentasCobrar) }} registros</span>
                        <button class="text-sm text-blue-800 hover:text-blue-900 font-medium">
                            Ver todas las cuentas →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de Cuentas por Pagar -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-red-50 to-orange-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Cuentas por Pagar</h3>
                            <p class="text-gray-600 text-sm">Total por pagar: $3,215,750</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition-colors duration-200">
                                <i class="fas fa-file-export mr-1"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Proveedor</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Vencimiento</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Monto</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $cuentasPagar = [
                                    ['proveedor' => 'CEMEX Materiales', 'vencimiento' => '18/03/2024', 'monto' => '$1,150,000', 'estado' => 'Pendiente'],
                                    ['proveedor' => 'Grupo Acerero MX', 'vencimiento' => '10/03/2024', 'monto' => '$850,750', 'estado' => 'Vencido'],
                                    ['proveedor' => 'Vidriera Nacional', 'vencimiento' => '25/03/2024', 'monto' => '$625,000', 'estado' => 'Pendiente'],
                                    ['proveedor' => 'Electricidad Total', 'vencimiento' => '05/03/2024', 'monto' => '$310,000', 'estado' => 'Pagado'],
                                    ['proveedor' => 'Renta de Maquinaria', 'vencimiento' => '30/03/2024', 'monto' => '$280,000', 'estado' => 'Pendiente'],
                                ];
                            @endphp
                            @foreach($cuentasPagar as $cuenta)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 text-base">{{ $cuenta['proveedor'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm text-gray-900">{{ $cuenta['vencimiento'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 text-base">{{ $cuenta['monto'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $estadoColors = [
                                            'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'Vencido' => 'bg-red-100 text-red-800',
                                            'Pagado' => 'bg-green-100 text-green-800'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $estadoColors[$cuenta['estado']] }}">
                                        {{ $cuenta['estado'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Mostrando {{ count($cuentasPagar) }} registros</span>
                        <button class="text-sm text-blue-800 hover:text-blue-900 font-medium">
                            Ver todas las cuentas →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de Estado de Resultados -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Estado de Resultados</h3>
                            <p class="text-gray-600 text-sm">Año 2024 (Ene-Feb)</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition-colors duration-200">
                                <i class="fas fa-chart-line mr-1"></i> Gráfico
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Concepto</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Monto</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">% Ventas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $estadoResultados = [
                                    ['concepto' => 'Ventas Netas', 'monto' => '$42,500,000', 'porcentaje' => '100%', 'tipo' => 'ingreso'],
                                    ['concepto' => 'Costo de Ventas', 'monto' => '$27,625,000', 'porcentaje' => '65%', 'tipo' => 'costo'],
                                    ['concepto' => 'Utilidad Bruta', 'monto' => '$14,875,000', 'porcentaje' => '35%', 'tipo' => 'utilidad'],
                                    ['concepto' => 'Gastos Operativos', 'monto' => '$8,075,000', 'porcentaje' => '19%', 'tipo' => 'gasto'],
                                    ['concepto' => 'Utilidad Operativa', 'monto' => '$6,800,000', 'porcentaje' => '16%', 'tipo' => 'utilidad'],
                                    ['concepto' => 'Impuestos', 'monto' => '$2,040,000', 'porcentaje' => '4.8%', 'tipo' => 'impuesto'],
                                    ['concepto' => 'Utilidad Neta', 'monto' => '$4,760,000', 'porcentaje' => '11.2%', 'tipo' => 'neto'],
                                ];
                            @endphp
                            @foreach($estadoResultados as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 text-base">{{ $item['concepto'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $colorClass = '';
                                        if($item['tipo'] == 'ingreso') $colorClass = 'text-green-600';
                                        elseif($item['tipo'] == 'costo' || $item['tipo'] == 'gasto' || $item['tipo'] == 'impuesto') $colorClass = 'text-red-600';
                                        elseif($item['tipo'] == 'utilidad' || $item['tipo'] == 'neto') $colorClass = 'text-blue-600';
                                    @endphp
                                    <div class="font-bold {{ $colorClass }} text-base">{{ $item['monto'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 text-base">{{ $item['porcentaje'] }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-600">Margen Neto: </span>
                            <span class="text-sm font-bold text-green-600">11.2%</span>
                        </div>
                        <button class="text-sm text-blue-800 hover:text-blue-900 font-medium">
                            Ver detalle completo →
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 1: KPIs Estratégicos Principales -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-10">
            <!-- KPI 1: Salud Financiera -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 text-white p-6 shadow-xl transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mt-16 -mr-16"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-blue-100 font-medium text-sm">Salud Financiera Global</p>
                            <h3 class="text-4xl font-bold mt-2">92.8%</h3>
                            <div class="flex items-center mt-2">
                                <span class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i> +3.2%
                                </span>
                                <span class="ml-3 text-blue-200 text-xs">vs trimestre anterior</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-blue-100">Liquidez Corriente</span>
                                <span class="font-semibold">1.8:1</span>
                            </div>
                            <div class="w-full bg-blue-700/50 rounded-full h-2">
                                <div class="bg-green-400 h-2 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-blue-100">Margen EBITDA</span>
                                <span class="font-semibold">24.5%</span>
                            </div>
                            <div class="w-full bg-blue-700/50 rounded-full h-2">
                                <div class="bg-green-400 h-2 rounded-full" style="width: 82%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-blue-100">ROI Promedio</span>
                                <span class="font-semibold">18.7%</span>
                            </div>
                            <div class="w-full bg-blue-700/50 rounded-full h-2">
                                <div class="bg-green-400 h-2 rounded-full" style="width: 94%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-blue-600/30">
                        <div class="flex justify-between text-xs">
                            <span class="text-blue-200">Deuda/Patrimonio</span>
                            <span class="font-semibold">0.65</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- KPI 2: Desempeño de Proyectos -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 text-white p-6 shadow-xl transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mt-16 -mr-16"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-gray-100 font-medium text-sm">Desempeño Proyectos</p>
                            <h3 class="text-4xl font-bold mt-2">84.3%</h3>
                            <div class="flex items-center mt-2">
                                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs flex items-center">
                                    <i class="fas fa-minus mr-1"></i> -1.5%
                                </span>
                                <span class="ml-3 text-gray-200 text-xs">vs mes anterior</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-hard-hat text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-300 text-xs">Proyectos Activos</p>
                                <p class="text-2xl font-bold">12</p>
                            </div>
                            <div>
                                <p class="text-gray-300 text-xs">En Riesgo</p>
                                <p class="text-2xl font-bold text-yellow-400">3</p>
                            </div>
                            <div>
                                <p class="text-gray-300 text-xs">Críticos</p>
                                <p class="text-2xl font-bold text-red-400">2</p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-800/50 rounded-lg p-3">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-gray-300">Cumplimiento Cronograma</span>
                                <span class="font-semibold">78%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-800/50 rounded-lg p-3">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-gray-300">Control Presupuestal</span>
                                <span class="font-semibold text-green-400">+2.3%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 95%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-600/30">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-200 text-xs">Atraso Promedio</span>
                            <span class="font-semibold text-yellow-400">-7 días</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- KPI 3: Ventas y Comercial -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-900 via-green-800 to-green-700 text-white p-6 shadow-xl transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mt-16 -mr-16"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-green-100 font-medium text-sm">Ventas Inmobiliarias</p>
                            <h3 class="text-4xl font-bold mt-2">$148.2M</h3>
                            <div class="flex items-center mt-2">
                                <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i> +22.4%
                                </span>
                                <span class="ml-3 text-green-200 text-xs">vs año anterior</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-home text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-green-800/30 rounded-lg p-3">
                                <p class="text-green-200 text-xs">Unidades Vendidas</p>
                                <p class="text-2xl font-bold">142</p>
                                <p class="text-green-300 text-xs">87% de meta</p>
                            </div>
                            <div class="bg-green-800/30 rounded-lg p-3">
                                <p class="text-green-200 text-xs">Contratos Pendientes</p>
                                <p class="text-2xl font-bold">28</p>
                                <p class="text-green-300 text-xs">$24.3M</p>
                            </div>
                        </div>
                        
                        <div class="bg-green-800/30 rounded-lg p-3">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-green-200">Tasa de Conversión</span>
                                <span class="font-semibold">34.7%</span>
                            </div>
                            <div class="w-full bg-green-700/50 rounded-full h-2">
                                <div class="bg-white h-2 rounded-full" style="width: 34.7%"></div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between text-xs">
                            <div>
                                <p class="text-green-200">Cartera Vencida</p>
                                <p class="text-lg font-semibold text-red-300">$1.2M</p>
                            </div>
                            <div>
                                <p class="text-green-200">Morosidad</p>
                                <p class="text-lg font-semibold">2.8%</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-green-600/30">
                        <div class="flex justify-between items-center">
                            <span class="text-green-200 text-xs">Valor Promedio Venta</span>
                            <span class="font-semibold">$1.04M</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- KPI 4: Operaciones y Logística -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-900 via-orange-800 to-orange-700 text-white p-6 shadow-xl transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mt-16 -mr-16"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-orange-100 font-medium text-sm">Eficiencia Operativa</p>
                            <h3 class="text-4xl font-bold mt-2">76.5%</h3>
                            <div class="flex items-center mt-2">
                                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i> +4.1%
                                </span>
                                <span class="ml-3 text-orange-200 text-xs">vs trimestre anterior</span>
                            </div>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-cogs text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center">
                                <p class="text-orange-200 text-xs">Inventario</p>
                                <p class="text-xl font-bold">94%</p>
                            </div>
                            <div class="text-center">
                                <p class="text-orange-200 text-xs">Maquinaria</p>
                                <p class="text-xl font-bold">87%</p>
                            </div>
                            <div class="text-center">
                                <p class="text-orange-200 text-xs">Personal</p>
                                <p class="text-xl font-bold">92%</p>
                            </div>
                        </div>
                        
                        <div class="bg-orange-800/30 rounded-lg p-3">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-orange-200">Disponibilidad Equipos</span>
                                <span class="font-semibold">89.3%</span>
                            </div>
                            <div class="w-full bg-orange-700/50 rounded-full h-2">
                                <div class="bg-green-400 h-2 rounded-full" style="width: 89.3%"></div>
                            </div>
                        </div>
                        
                        <div class="bg-orange-800/30 rounded-lg p-3">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="text-orange-200">Costo/Hora Productiva</span>
                                <span class="font-semibold">$142.50</span>
                            </div>
                            <div class="w-full bg-orange-700/50 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-orange-600/30">
                        <div class="flex justify-between items-center">
                            <span class="text-orange-200 text-xs">Costo Indirecto/Obra</span>
                            <span class="font-semibold">18.4%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 2: Gráficos y Visualizaciones -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Gráfico 1: Evolución Financiera -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Evolución Financiera Anual</h3>
                        <p class="text-gray-600 text-sm">Comparativo ingresos vs gastos vs utilidad (M$)</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-blue-800 text-white rounded-lg text-sm hover:bg-blue-900 transition-colors duration-200 active-filter" data-filter="all">
                            <i class="fas fa-chart-bar mr-1"></i> Todos
                        </button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" data-filter="income">
                            <i class="fas fa-money-bill-wave mr-1"></i> Ingresos
                        </button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" data-filter="profit">
                            <i class="fas fa-chart-line mr-1"></i> Utilidad
                        </button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="financialEvolutionChart"></canvas>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-4">
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-700">Ingresos Acumulados</p>
                        <p class="text-2xl font-bold text-blue-800">$148.2M</p>
                        <p class="text-xs text-green-600"><i class="fas fa-arrow-up mr-1"></i> +18.7%</p>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <p class="text-sm text-red-700">Costos Directos</p>
                        <p class="text-2xl font-bold text-red-800">$96.8M</p>
                        <p class="text-xs text-red-600"><i class="fas fa-arrow-up mr-1"></i> +14.2%</p>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-700">Utilidad Neta</p>
                        <p class="text-2xl font-bold text-green-800">$38.4M</p>
                        <p class="text-xs text-green-600"><i class="fas fa-arrow-up mr-1"></i> +24.3%</p>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico 2: Distribución por Segmento -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Distribución por Segmento</h3>
                        <p class="text-gray-600 text-sm">Mix de negocios actual</p>
                    </div>
                    <select class="bg-gray-100 border-0 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800 text-sm">
                        <option>Este año</option>
                        <option>2023</option>
                        <option>2022</option>
                    </select>
                </div>
                <div class="h-64 mb-6">
                    <canvas id="segmentDistributionChart"></canvas>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-600 mr-2"></div>
                            <span class="text-sm">Residencial</span>
                        </div>
                        <span class="font-semibold">42.8%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-600 mr-2"></div>
                            <span class="text-sm">Comercial</span>
                        </div>
                        <span class="font-semibold">28.5%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-orange-500 mr-2"></div>
                            <span class="text-sm">Industrial</span>
                        </div>
                        <span class="font-semibold">18.2%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-purple-600 mr-2"></div>
                            <span class="text-sm">Infraestructura</span>
                        </div>
                        <span class="font-semibold">10.5%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 3: Proyectos Estratégicos y Estado -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Tabla de Proyectos Críticos -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-gray-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Proyectos Estratégicos</h3>
                            <p class="text-gray-600 text-sm">Monitoreo en tiempo real</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-blue-800 text-white rounded-lg text-sm hover:bg-blue-900 transition-colors duration-200">
                                <i class="fas fa-plus mr-1"></i> Nuevo
                            </button>
                            <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200">
                                <i class="fas fa-filter mr-1"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Proyecto</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Estado</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Avance</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Financiero</th>
                                <th class="text-left py-4 px-6 text-gray-700 font-semibold text-sm uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @for($i = 1; $i <= 8; $i++)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 text-base">Torre Ejecutiva Corporativa {{$i}}</div>
                                    <div class="text-sm text-gray-500">CDMX - Polanco</div>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800">Presupuesto: ${{rand(10,50)}}M</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $status = ['Crítico', 'Atención', 'En tiempo', 'Finalizando'][rand(0,3)];
                                        $colors = [
                                            'Crítico' => 'bg-red-100 text-red-800',
                                            'Atención' => 'bg-yellow-100 text-yellow-800',
                                            'En tiempo' => 'bg-green-100 text-green-800',
                                            'Finalizando' => 'bg-blue-100 text-blue-800'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{$colors[$status]}}">{{$status}}</span>
                                    <div class="text-xs text-gray-500 mt-1">Gerente: Ing. López</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2.5 mr-3">
                                            <div class="h-2.5 rounded-full 
                                                @if($status == 'Crítico') bg-red-500
                                                @elseif($status == 'Atención') bg-yellow-500
                                                @elseif($status == 'En tiempo') bg-green-500
                                                @else bg-blue-500
                                                @endif" 
                                                style="width: {{rand(40,95)}}%">
                                            </div>
                                        </div>
                                        <span class="font-medium">{{rand(40,95)}}%</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{rand(0,15)}} días {{rand(0,1) ? 'adelantado' : 'atrasado'}}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $financial = rand(-200,200) * 1000;
                                        $color = $financial >= 0 ? 'text-green-600' : 'text-red-600';
                                        $sign = $financial >= 0 ? '+' : '';
                                    @endphp
                                    <div class="font-medium {{$color}} text-base">{{$sign}}${{number_format(abs($financial))}}</div>
                                    <div class="text-sm text-gray-500">{{$financial >= 0 ? 'Bajo costo' : 'Sobre costo'}}</div>
                                    <div class="text-xs text-gray-500 mt-1">Variación: {{rand(1,15)}}%</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex space-x-2">
                                        <button class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="p-1.5 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200" title="Reporte">
                                            <i class="fas fa-file-alt"></i>
                                        </button>
                                        <button class="p-1.5 text-purple-600 hover:text-purple-800 hover:bg-purple-50 rounded-lg transition-colors duration-200" title="Comentarios">
                                            <i class="fas fa-comment"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Mostrando 8 de 24 proyectos activos</span>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded-lg text-sm hover:bg-gray-300 transition-colors duration-200">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="px-3 py-1.5 bg-blue-800 text-white rounded-lg text-sm hover:bg-blue-900 transition-colors duration-200">
                                1
                            </button>
                            <button class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded-lg text-sm hover:bg-gray-300 transition-colors duration-200">
                                2
                            </button>
                            <button class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded-lg text-sm hover:bg-gray-300 transition-colors duration-200">
                                3
                            </button>
                            <button class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded-lg text-sm hover:bg-gray-300 transition-colors duration-200">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mapa de Proyectos y Alertas - MEJORADO -->
            <div class="space-y-8">
                <!-- Mapa de Calor de Proyectos - MEJORADO -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Mapa Interactivo de Proyectos</h3>
                            <p class="text-gray-600 text-sm">Distribución nacional con foco en Nuevo León y CDMX</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                <span class="text-xs">Normal</span>
                            </div>
                            <div class="flex items-center ml-2">
                                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                <span class="text-xs">Alerta</span>
                            </div>
                            <div class="flex items-center ml-2">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-1"></div>
                                <span class="text-xs">Crítico</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative h-80 bg-gradient-to-br from-blue-50 to-gray-100 rounded-xl overflow-hidden border-2 border-gray-300">
                        <!-- Mapa simulado con ciudades específicas -->
                        <div class="absolute inset-0">
                            <!-- Representación de México -->
                            <div class="absolute top-1/4 left-1/4 w-32 h-40 border-2 border-gray-400 rounded-lg bg-white/50">
                                <!-- CDMX -->
                                <div class="absolute top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                    <div class="w-10 h-10 bg-purple-600 rounded-full border-4 border-white shadow-xl flex items-center justify-center cursor-pointer hover:scale-125 transition-transform duration-300 z-10" 
                                         title="Ciudad de México - 4 proyectos estratégicos">
                                        <span class="text-white text-xs font-bold">CDMX</span>
                                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 hover:opacity-100 transition-opacity">
                                            Proyectos: 4<br>Estado: Normal
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Representación de Nuevo León -->
                            <div class="absolute top-1/3 right-1/4 w-28 h-32 border-2 border-gray-400 rounded-lg bg-white/50">
                                <!-- Monterrey -->
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                    <div class="w-10 h-10 bg-blue-600 rounded-full border-4 border-white shadow-xl flex items-center justify-center cursor-pointer hover:scale-125 transition-transform duration-300 z-10"
                                         title="Monterrey, Nuevo León - 3 proyectos en desarrollo">
                                        <span class="text-white text-xs font-bold">NL</span>
                                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 hover:opacity-100 transition-opacity">
                                            Proyectos: 3<br>Estado: En alerta
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Etiquetas de ciudades -->
                            <div class="absolute top-1/3 left-1/4 mt-16 ml-2">
                                <div class="bg-white/90 px-3 py-1 rounded-lg shadow-sm">
                                    <span class="text-sm font-semibold text-gray-800">Ciudad de México</span>
                                    <div class="flex items-center mt-1">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
                                        <span class="text-xs text-gray-600">4 proyectos activos</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute top-1/3 right-1/4 mt-4 mr-2">
                                <div class="bg-white/90 px-3 py-1 rounded-lg shadow-sm">
                                    <span class="text-sm font-semibold text-gray-800">Nuevo León</span>
                                    <div class="flex items-center mt-1">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></div>
                                        <span class="text-xs text-gray-600">3 proyectos activos</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Otras ciudades -->
                            <div class="absolute bottom-1/4 left-1/3">
                                <div class="w-8 h-8 bg-green-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center cursor-pointer hover:scale-110 transition-transform duration-200" 
                                     title="Guadalajara - 2 proyectos">
                                    <span class="text-white text-xs">2</span>
                                </div>
                            </div>
                            
                            <div class="absolute bottom-1/3 right-1/3">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center cursor-pointer hover:scale-110 transition-transform duration-200" 
                                     title="Puebla - 1 proyecto">
                                    <span class="text-white text-xs">1</span>
                                </div>
                            </div>
                            
                            <!-- Leyenda interactiva -->
                            <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-3 rounded-lg shadow-lg">
                                <h4 class="font-semibold text-gray-800 text-sm mb-2">Resumen por Ciudad:</h4>
                                <div class="space-y-1 text-xs">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-purple-600 rounded-full mr-2"></div>
                                        <span class="text-gray-700">CDMX: 4 proyectos</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-600 rounded-full mr-2"></div>
                                        <span class="text-gray-700">Nuevo León: 3 proyectos</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                        <span class="text-gray-700">Otras: 5 proyectos</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-3 gap-4">
                        <div class="text-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors duration-200 cursor-pointer">
                            <p class="text-sm text-gray-600">Ciudad de México</p>
                            <p class="text-xl font-bold text-gray-900">4</p>
                            <p class="text-xs text-green-600">Proyectos activos</p>
                        </div>
                        <div class="text-center p-3 border border-gray-200 rounded-lg hover:bg-yellow-50 transition-colors duration-200 cursor-pointer">
                            <p class="text-sm text-gray-600">Nuevo León</p>
                            <p class="text-xl font-bold text-gray-900">3</p>
                            <p class="text-xs text-yellow-600">2 en desarrollo</p>
                        </div>
                        <div class="text-center p-3 border border-gray-200 rounded-lg hover:bg-green-50 transition-colors duration-200 cursor-pointer">
                            <p class="text-sm text-gray-600">Otras Ciudades</p>
                            <p class="text-xl font-bold text-gray-900">5</p>
                            <p class="text-xs text-green-600">Estables</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-center space-x-3">
                        <button class="px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors duration-200 text-sm flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i> Ver CDMX
                        </button>
                        <button class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors duration-200 text-sm flex items-center">
                            <i class="fas fa-map-marked-alt mr-2"></i> Ver Nuevo León
                        </button>
                        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-sm flex items-center">
                            <i class="fas fa-expand-alt mr-2"></i> Vista Completa
                        </button>
                    </div>
                </div>
                
                <!-- Panel de Alertas Urgentes -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Alertas Urgentes</h3>
                            <p class="text-gray-600 text-sm">Requieren atención inmediata</p>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">3 críticas</span>
                    </div>
                    
                    <div class="space-y-4 max-h-64 overflow-y-auto pr-2">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="border-l-4 
                            @if($i == 1) border-red-500 bg-red-50
                            @elseif($i == 2) border-yellow-500 bg-yellow-50
                            @else border-blue-500 bg-blue-50
                            @endif pl-4 py-3 rounded-r-lg hover:bg-opacity-80 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-medium text-gray-900 text-base">
                                        @if($i == 1) Retraso crítico en cimentación
                                        @elseif($i == 2) Sobrecosto en materiales
                                        @elseif($i == 3) Falta de permisos municipales
                                        @elseif($i == 4) Incidente de seguridad
                                        @else Cambio en especificaciones
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        @if($i == 1) Torre Norte: Retraso de 18 días
                                        @elseif($i == 2) Acero +22% sobre presupuesto
                                        @elseif($i == 3) Proyecto Plaza Sur - Urgente
                                        @elseif($i == 4) Área de almacén - Reportado hoy
                                        @else Cliente solicita modificación
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">
                                    @if($i == 1) Hace 2h
                                    @elseif($i == 2) Hace 5h
                                    @elseif($i == 3) Ayer
                                    @elseif($i == 4) Hoy 08:30
                                    @else 2 días
                                    @endif
                                </span>
                            </div>
                            <div class="flex mt-3">
                                <button class="text-xs px-3 py-1.5 
                                    @if($i == 1) bg-red-100 text-red-800 hover:bg-red-200
                                    @elseif($i == 2) bg-yellow-100 text-yellow-800 hover:bg-yellow-200
                                    @else bg-blue-100 text-blue-800 hover:bg-blue-200
                                    @endif rounded mr-2 transition-colors duration-200">
                                    @if($i == 1) Crítico
                                    @elseif($i == 2) Atención
                                    @else Revisar
                                    @endif
                                </button>
                                <button class="text-xs px-3 py-1.5 bg-gray-100 text-gray-800 hover:bg-gray-200 rounded transition-colors duration-200">
                                    Asignar
                                </button>
                                @if($i == 1)
                                <button class="text-xs px-3 py-1.5 bg-green-100 text-green-800 hover:bg-green-200 rounded ml-2 transition-colors duration-200">
                                    <i class="fas fa-phone-alt mr-1"></i> 
                                </button>
                                @endif
                            </div>
                        </div>
                        @endfor
                    </div>
                    
                    <div class="mt-6">
                        <button class="w-full py-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-600 hover:border-blue-800 hover:text-blue-800 hover:bg-blue-50 transition-all duration-200 flex items-center justify-center text-base">
                            <i class="fas fa-plus mr-2"></i> Crear nueva alerta
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 4: Análisis Detallado y Métricas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Métricas de Productividad -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Métricas de Productividad</h3>
                        <p class="text-gray-600 text-sm">Eficiencia por departamento</p>
                    </div>
                    <select class="bg-gray-100 border-0 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-800 text-sm">
                        <option>Este mes</option>
                        <option>Mes anterior</option>
                        <option>Este trimestre</option>
                    </select>
                </div>
                
                <div class="space-y-6">
                    @foreach(['Construcción', 'Diseño', 'Compras', 'Supervisión', 'Administración'] as $dept)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg 
                                    @if($dept == 'Construcción') bg-blue-100 text-blue-800
                                    @elseif($dept == 'Diseño') bg-purple-100 text-purple-800
                                    @elseif($dept == 'Compras') bg-green-100 text-green-800
                                    @elseif($dept == 'Supervisión') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif flex items-center justify-center mr-3">
                                    <i class="fas 
                                        @if($dept == 'Construcción') fa-hard-hat
                                        @elseif($dept == 'Diseño') fa-pencil-ruler
                                        @elseif($dept == 'Compras') fa-shopping-cart
                                        @elseif($dept == 'Supervisión') fa-clipboard-check
                                        @else fa-users
                                        @endif text-sm">
                                    </i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900 text-base">{{$dept}}</span>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span>{{rand(15,85)}} personas</span>
                                        <span class="mx-2">•</span>
                                        <span>{{rand(3,12)}} proyectos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold 
                                    @if($dept == 'Construcción') text-blue-800
                                    @elseif($dept == 'Diseño') text-purple-800
                                    @elseif($dept == 'Compras') text-green-800
                                    @elseif($dept == 'Supervisión') text-yellow-800
                                    @else text-gray-800
                                    @endif">
                                    {{rand(75,98)}}%
                                </span>
                                <div class="text-xs 
                                    @if(rand(0,1)) text-green-600 @else text-red-600 @endif">
                                    @if(rand(0,1))
                                    <i class="fas fa-arrow-up mr-1"></i> +{{rand(1,5)}}%
                                    @else
                                    <i class="fas fa-arrow-down mr-1"></i> -{{rand(1,3)}}%
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full 
                                @if($dept == 'Construcción') bg-blue-600
                                @elseif($dept == 'Diseño') bg-purple-600
                                @elseif($dept == 'Compras') bg-green-600
                                @elseif($dept == 'Supervisión') bg-yellow-600
                                @else bg-gray-600
                                @endif" 
                                style="width: {{rand(70,98)}}%">
                            </div>
                        </div>
                        
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>Meta: 85%</span>
                            <span>Variación: ±{{rand(1,8)}}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                        <p class="text-sm text-blue-700">Horas Productivas</p>
                        <p class="text-2xl font-bold text-blue-800">12,847</p>
                        <p class="text-xs text-blue-600">+8.2%</p>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                        <p class="text-sm text-green-700">Costo/Hora</p>
                        <p class="text-2xl font-bold text-green-800">$142.50</p>
                        <p class="text-xs text-green-600">-3.1%</p>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl">
                        <p class="text-sm text-yellow-700">Eficiencia</p>
                        <p class="text-2xl font-bold text-yellow-800">78.4%</p>
                        <p class="text-xs text-yellow-600">+2.3%</p>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                        <p class="text-sm text-purple-700">Productividad</p>
                        <p class="text-2xl font-bold text-purple-800">1.24</p>
                        <p class="text-xs text-purple-600">+4.7%</p>
                    </div>
                </div>
            </div>
            
            <!-- Panel de Control y Acciones Rápidas -->
            <div class="space-y-8">
                <!-- Panel de Control -->
                <div class="bg-gradient-to-br from-blue-900 to-blue-800 rounded-2xl p-6 text-white shadow-xl">
                    <h3 class="text-xl font-bold mb-6">Panel de Control</h3>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button class="p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors duration-200 flex flex-col items-center justify-center">
                            <i class="fas fa-play-circle text-2xl mb-2"></i>
                            <span class="text-sm">Iniciar Proyecto</span>
                        </button>
                        <button class="p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors duration-200 flex flex-col items-center justify-center">
                            <i class="fas fa-file-alt text-2xl mb-2"></i>
                            <span class="text-sm">Reporte Diario</span>
                        </button>
                        <button class="p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors duration-200 flex flex-col items-center justify-center">
                            <i class="fas fa-chart-pie text-2xl mb-2"></i>
                            <span class="text-sm">Análisis</span>
                        </button>
                        <button class="p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors duration-200 flex flex-col items-center justify-center">
                            <i class="fas fa-cog text-2xl mb-2"></i>
                            <span class="text-sm">Configurar</span>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-video mr-3"></i>
                                <span>Reunión Ejecutiva</span>
                            </div>
                            <span class="text-blue-200 text-sm">10:30 AM</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-file-signature mr-3"></i>
                                <span>Firma Contrato</span>
                            </div>
                            <span class="text-blue-200 text-sm">2:00 PM</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-hard-hat mr-3"></i>
                                <span>Visita Obra</span>
                            </div>
                            <span class="text-blue-200 text-sm">4:00 PM</span>
                        </div>
                    </div>
                </div>
                
                <!-- Resumen Ejecutivo -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Resumen Ejecutivo</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-green-100 text-green-800 flex items-center justify-center mr-3">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-base">Proyectos en Tiempo</p>
                                    <p class="text-sm text-gray-600">7 de 12 proyectos</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-green-600">58%</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center mr-3">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-base">Crecimiento Anual</p>
                                    <p class="text-sm text-gray-600">Ingresos vs 2023</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-blue-600">+22%</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-800 flex items-center justify-center mr-3">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-base">Riesgos Activos</p>
                                    <p class="text-sm text-gray-600">Requieren atención</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-yellow-600">8</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-800 flex items-center justify-center mr-3">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-base">Satisfacción Cliente</p>
                                    <p class="text-sm text-gray-600">Encuesta Q3</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-purple-600">4.8/5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 5: Perspectivas y Pronósticos -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 mb-10">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Perspectivas y Pronósticos</h3>
                    <p class="text-gray-600 text-base">Proyecciones para los próximos 12 meses</p>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors duration-200 text-base">
                        <i class="fas fa-download mr-2"></i> Exportar Pronóstico
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-base">
                        <i class="fas fa-sliders-h mr-2"></i> Ajustar
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-blue-700">Ingresos Proyectados</p>
                            <p class="text-2xl font-bold text-blue-900">$185.4M</p>
                        </div>
                        <i class="fas fa-chart-line text-2xl text-blue-600"></i>
                    </div>
                    <div class="text-sm text-blue-800">
                        <p><i class="fas fa-arrow-up mr-1 text-green-600"></i> Crecimiento esperado: +25%</p>
                        <p class="mt-1">Basado en cartera actual</p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-green-700">Nuevos Proyectos</p>
                            <p class="text-2xl font-bold text-green-900">8-10</p>
                        </div>
                        <i class="fas fa-hard-hat text-2xl text-green-600"></i>
                    </div>
                    <div class="text-sm text-green-800">
                        <p><i class="fas fa-briefcase mr-1"></i> Valor estimado: $120M</p>
                        <p class="mt-1">En pipeline comercial</p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-yellow-700">Margen Esperado</p>
                            <p class="text-2xl font-bold text-yellow-900">26.5%</p>
                        </div>
                        <i class="fas fa-percentage text-2xl text-yellow-600"></i>
                    </div>
                    <div class="text-sm text-yellow-800">
                        <p><i class="fas fa-chart-line mr-1"></i> Mejora: +2.1 puntos</p>
                        <p class="mt-1">Optimización de costos</p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-purple-700">ROI Proyectado</p>
                            <p class="text-2xl font-bold text-purple-900">21.8%</p>
                        </div>
                        <i class="fas fa-hand-holding-usd text-2xl text-purple-600"></i>
                    </div>
                    <div class="text-sm text-purple-800">
                        <p><i class="fas fa-arrow-up mr-1 text-green-600"></i> Incremento: +3.1%</p>
                        <p class="mt-1">Retorno sobre inversión</p>
                    </div>
                </div>
            </div>
            
            <div class="h-64">
                <canvas id="forecastChart"></canvas>
            </div>
        </div>

        <!-- Footer del Dashboard -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <p class="text-gray-600 text-base">
                        <i class="fas fa-info-circle text-blue-800 mr-1"></i>
                        Dashboard ejecutivo para dirección - Actualizado automáticamente cada 15 minutos
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Última actualización: {{ now()->format('d/m/Y H:i:s') }} | 
                        Versión: 3.2.1 | 
                        <span class="text-green-600"><i class="fas fa-circle text-xs mr-1"></i>Sistema operativo</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm">
                        <i class="fas fa-question-circle mr-2"></i> Ayuda
                    </button>
                    <button class="px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors duration-200 text-sm">
                        <i class="fas fa-sync-alt mr-2"></i> Preguntas Frecuentes
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configurar colores principales
    const primaryBlue = '#083CAE';
    const primaryGreen = '#2cbf1f';
    
    // Gráfico de Evolución Financiera
    const financialCtx = document.getElementById('financialEvolutionChart')?.getContext('2d');
    if (financialCtx) {
        new Chart(financialCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [
                    {
                        label: 'Ingresos (M$)',
                        data: [10.2, 11.5, 12.8, 13.2, 14.5, 15.8, 16.2, 15.8, 16.5, 17.2, 18.5, 19.2],
                        borderColor: primaryBlue,
                        backgroundColor: 'rgba(8, 60, 174, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Utilidad (M$)',
                        data: [2.1, 2.4, 2.8, 3.1, 3.4, 3.8, 4.1, 3.9, 4.2, 4.5, 4.9, 5.2],
                        borderColor: primaryGreen,
                        backgroundColor: 'rgba(44, 191, 31, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Millones de USD'
                        }
                    }
                }
            }
        });
    }
    
    // Gráfico de Distribución por Segmento
    const segmentCtx = document.getElementById('segmentDistributionChart')?.getContext('2d');
    if (segmentCtx) {
        new Chart(segmentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Residencial', 'Comercial', 'Industrial', 'Infraestructura'],
                datasets: [{
                    data: [42.8, 28.5, 18.2, 10.5],
                    backgroundColor: [
                        primaryBlue,
                        primaryGreen,
                        '#f59e0b',
                        '#8b5cf6'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
    
    // Gráfico de Pronóstico
    const forecastCtx = document.getElementById('forecastChart')?.getContext('2d');
    if (forecastCtx) {
        new Chart(forecastCtx, {
            type: 'bar',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4', 'Q1 2025', 'Q2 2025'],
                datasets: [
                    {
                        label: 'Pronóstico',
                        data: [38.2, 42.5, 45.8, 48.3, 52.1, 56.8],
                        backgroundColor: 'rgba(8, 60, 174, 0.7)',
                        borderColor: primaryBlue,
                        borderWidth: 2
                    },
                    {
                        label: 'Real',
                        data: [36.8, 40.2, null, null, null, null],
                        backgroundColor: 'rgba(44, 191, 31, 0.7)',
                        borderColor: primaryGreen,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Ingresos (M$)'
                        }
                    }
                }
            }
        });
    }
    
    // Interactividad de botones
    document.querySelectorAll('.active-filter').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('[data-filter]').forEach(btn => {
                btn.classList.remove('bg-blue-800', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-800');
            });
            this.classList.remove('bg-gray-100', 'text-gray-800');
            this.classList.add('bg-blue-800', 'text-white');
        });
    });
    
    // Interactividad para el mapa
    document.querySelectorAll('.cursor-pointer').forEach(element => {
        element.addEventListener('click', function() {
            const title = this.getAttribute('title');
            if (title) {
                alert(title);
            }
        });
    });
    
    // Botones del mapa
    document.querySelector('button:contains("Ver CDMX")')?.addEventListener('click', function() {
        alert('Mostrando detalles de proyectos en Ciudad de México');
    });
    
    document.querySelector('button:contains("Ver Nuevo León")')?.addEventListener('click', function() {
        alert('Mostrando detalles de proyectos en Nuevo León');
    });
    
    // Simulación de datos en tiempo real
    function updateRealTimeData() {
        const elements = document.querySelectorAll('.real-time-data');
        elements.forEach(el => {
            const current = parseFloat(el.textContent);
            const change = (Math.random() - 0.5) * 2;
            const newValue = Math.max(0, current + change);
            el.textContent = newValue.toFixed(1);
            
            // Actualizar color basado en cambio
            const parent = el.closest('.bg-gradient-to-br');
            if (parent) {
                if (change > 0) {
                    el.classList.remove('text-red-600');
                    el.classList.add('text-green-600');
                } else {
                    el.classList.remove('text-green-600');
                    el.classList.add('text-red-600');
                }
            }
        });
    }
    
    // Actualizar cada 30 segundos (simulación)
    setInterval(updateRealTimeData, 30000);
});
</script>

<style>
/* Estilos personalizados adicionales */
@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 5px rgba(8, 60, 174, 0.5); }
    50% { box-shadow: 0 0 20px rgba(8, 60, 174, 0.8); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.glow-card {
    animation: pulse-glow 3s infinite;
}

.float-card {
    animation: float 6s ease-in-out infinite;
}

/* Estilos para scrollbar personalizado */
.dashboard-scrollbar::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.dashboard-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.dashboard-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.dashboard-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Efectos de hover mejorados */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Gradientes personalizados */
.bg-gradient-executive {
    background: linear-gradient(135deg, #083CAE 0%, #2cbf1f 100%);
}

.text-gradient-executive {
    background: linear-gradient(135deg, #083CAE 0%, #2cbf1f 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Estilos para badges de estado */
.status-badge {
    @apply px-3 py-1 rounded-full text-xs font-medium;
}

.status-critical {
    @apply bg-red-100 text-red-800;
}

.status-warning {
    @apply bg-yellow-100 text-yellow-800;
}

.status-normal {
    @apply bg-green-100 text-green-800;
}

.status-info {
    @apply bg-blue-100 text-blue-800;
}

/* Efectos de carga para datos en tiempo real */
.loading-pulse {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Mejoras responsivas */
@media (max-width: 768px) {
    .mobile-stack {
        flex-direction: column;
    }
    
    .mobile-full {
        width: 100%;
    }
}

/* Estilos para tooltips personalizados */
.custom-tooltip {
    position: relative;
}

.custom-tooltip:hover::after {
    content: attr(title);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: #1f2937;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
    margin-bottom: 8px;
}

.custom-tooltip:hover::before {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 6px solid transparent;
    border-top-color: #1f2937;
    margin-bottom: 2px;
    z-index: 1000;
}

/* Ajustes de tamaño de letra para mejor legibilidad */
.text-base {
    font-size: 1rem !important;
}

h1, h2, h3, h4, h5, h6 {
    font-size: 1.1em !important;
}

.text-sm {
    font-size: 0.95rem !important;
}

.text-xs {
    font-size: 0.85rem !important;
}

.font-medium {
    font-weight: 500 !important;
}

/* Mejorar legibilidad en tablas */
table {
    font-size: 0.95rem !important;
}

td, th {
    padding: 12px 16px !important;
}
</style>
@endsection