@extends('layouts.navigation')
@section('content')
<!-- Contenido principal -->
<div class="min-h-screen bg-gray-50 text-gray-800 pt-16">
    <main class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Header de Tareas -->
        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6">
                <div>
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 to-green-500 flex items-center justify-center">
                            <i class="fas fa-tasks text-2xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900">Gestión de Tareas</h1>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-lg text-gray-600">Bienvenido, <span class="font-semibold text-blue-800">{{ Auth::user()->name ?? 'Ing. Juan Martínez' }}</span></span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Gerente de Proyectos</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 max-w-3xl text-base">Gestión de tareas personales, asignaciones y seguimiento de productividad</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex gap-3">
                        <div class="relative">
                            <select class="appearance-none bg-white border border-gray-300 rounded-lg py-3 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-sm text-base">
                                <option>Hoy</option>
                                <option>Esta semana</option>
                                <option>Este mes</option>
                                <option>Todos</option>
                                <option>Vencidos</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg flex items-center transition-all duration-200 shadow-md hover:shadow-lg text-base" onclick="openNewTaskModal()">
                                <i class="fas fa-plus mr-2"></i> Nueva Tarea
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats Tareas -->
            <div class="mt-8 flex flex-wrap gap-3">
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Tareas Pendientes</p>
                            <p class="text-2xl font-bold text-gray-900">12</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded-full">+2 desde ayer</span>
                            </div>
                        </div>
                        <i class="fas fa-clock text-3xl text-blue-600 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Completadas Hoy</p>
                            <p class="text-2xl font-bold text-gray-900">8</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">+3% productividad</span>
                            </div>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-500 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Tiempo Promedio</p>
                            <p class="text-2xl font-bold text-gray-900">2.5h</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">-15 min vs ayer</span>
                            </div>
                        </div>
                        <i class="fas fa-stopwatch text-3xl text-purple-500 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[200px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Productividad</p>
                            <p class="text-2xl font-bold text-gray-900">78%</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Meta: 85%</span>
                            </div>
                        </div>
                        <i class="fas fa-chart-line text-3xl text-orange-500 opacity-70"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección Principal: Tareas y Productividad -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Columna 1: Tareas Pendientes -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Lista de Tareas Pendientes -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Tareas Pendientes</h3>
                                <p class="text-gray-600 text-sm">12 tareas pendientes • 4 vencidas</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors duration-200" onclick="filterTasks('all')">
                                    Todas
                                </button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="filterTasks('high')">
                                    Alta Prioridad
                                </button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="filterTasks('today')">
                                    Para Hoy
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200 max-h-[500px] overflow-y-auto">
                        @php
                            $pendingTasks = [
                                [
                                    'id' => 1,
                                    'title' => 'Revisar presupuesto proyecto Torre Norte',
                                    'description' => 'Analizar desviaciones presupuestarias y proponer ajustes',
                                    'priority' => 'high',
                                    'due_date' => 'Hoy, 14:00',
                                    'project' => 'Torre Norte',
                                    'assigner' => 'Director General',
                                    'status' => 'pending',
                                    'time_estimate' => '2 horas',
                                    'tags' => ['Presupuesto', 'Análisis']
                                ],
                                [
                                    'id' => 2,
                                    'title' => 'Firmar contrato con proveedor de acero',
                                    'description' => 'Revisar cláusulas y firmar contrato por $850,000',
                                    'priority' => 'medium',
                                    'due_date' => 'Mañana, 10:00',
                                    'project' => 'Plaza Central',
                                    'assigner' => 'Compras',
                                    'status' => 'pending',
                                    'time_estimate' => '1 hora',
                                    'tags' => ['Legal', 'Contratos']
                                ],
                                [
                                    'id' => 3,
                                    'title' => 'Revisión de avance con equipo de construcción',
                                    'description' => 'Reunión semanal para revisar avances y problemas',
                                    'priority' => 'high',
                                    'due_date' => 'Hoy, 16:30',
                                    'project' => 'Todos',
                                    'assigner' => 'Auto-asignada',
                                    'status' => 'in_progress',
                                    'time_estimate' => '1.5 horas',
                                    'tags' => ['Reunión', 'Seguimiento']
                                ],
                                [
                                    'id' => 4,
                                    'title' => 'Preparar reporte ejecutivo mensual',
                                    'description' => 'Consolidar métricas y preparar presentación para junta directiva',
                                    'priority' => 'medium',
                                    'due_date' => 'Vencido (Ayer)',
                                    'project' => 'Administración',
                                    'assigner' => 'Junta Directiva',
                                    'status' => 'overdue',
                                    'time_estimate' => '3 horas',
                                    'tags' => ['Reporte', 'Ejecutivo']
                                ],
                                [
                                    'id' => 5,
                                    'title' => 'Visita a obra en Santa Catarina',
                                    'description' => 'Inspección de calidad y revisión de cronograma',
                                    'priority' => 'low',
                                    'due_date' => '15 Mar, 09:00',
                                    'project' => 'Villas del Norte',
                                    'assigner' => 'Supervisor',
                                    'status' => 'pending',
                                    'time_estimate' => '4 horas',
                                    'tags' => ['Visita', 'Calidad']
                                ],
                                [
                                    'id' => 6,
                                    'title' => 'Capacitación equipo nuevo software',
                                    'description' => 'Entrenar al equipo en uso de nuevo sistema de gestión',
                                    'priority' => 'medium',
                                    'due_date' => '18 Mar, 11:00',
                                    'project' => 'Sistemas',
                                    'assigner' => 'TI',
                                    'status' => 'pending',
                                    'time_estimate' => '2 horas',
                                    'tags' => ['Capacitación', 'Sistemas']
                                ],
                            ];
                        @endphp
                        
                        @foreach($pendingTasks as $task)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-150 task-item" data-priority="{{ $task['priority'] }}" data-status="{{ $task['status'] }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3 flex-1">
                                    <div class="mt-1">
                                        <input type="checkbox" class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500" onchange="completeTask({{ $task['id'] }})">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900 text-base">{{ $task['title'] }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">{{ $task['description'] }}</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($task['priority'] == 'high')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Alta</span>
                                                @elseif($task['priority'] == 'medium')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Media</span>
                                                @else
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Baja</span>
                                                @endif
                                                
                                                @if($task['status'] == 'overdue')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Vencido</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center mt-3 space-x-4">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-day mr-1 text-blue-500"></i>
                                                <span class="{{ $task['status'] == 'overdue' ? 'text-red-600 font-medium' : '' }}">{{ $task['due_date'] }}</span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-clock mr-1 text-purple-500"></i>
                                                <span>{{ $task['time_estimate'] }}</span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-project-diagram mr-1 text-green-500"></i>
                                                <span>{{ $task['project'] }}</span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-user-tie mr-1 text-orange-500"></i>
                                                <span>{{ $task['assigner'] }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center mt-3">
                                            @foreach($task['tags'] as $tag)
                                            <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded mr-2">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="ml-4 flex items-center space-x-2">
                                    <button class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="Editar" onclick="editTask({{ $task['id'] }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200" title="Comenzar" onclick="startTask({{ $task['id'] }})">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Eliminar" onclick="deleteTask({{ $task['id'] }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Mostrando {{ count($pendingTasks) }} de 12 tareas pendientes</span>
                            <button class="text-sm text-blue-800 hover:text-blue-900 font-medium" onclick="loadMoreTasks()">
                                <i class="fas fa-redo mr-1"></i> Cargar más
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Tareas Completadas Recientemente -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Completadas Hoy</h3>
                                <p class="text-gray-600 text-sm">8 tareas completadas • 14 horas productivas</p>
                            </div>
                            <button class="px-3 py-1 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 transition-colors duration-200" onclick="showCompletedTasks()">
                                Ver Todas
                            </button>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto">
                        @php
                            $completedTasks = [
                                [
                                    'title' => 'Revisar reporte de seguridad',
                                    'time' => '2.5 horas',
                                    'completed_at' => 'Hoy, 09:30',
                                    'efficiency' => '95%'
                                ],
                                [
                                    'title' => 'Llamada con cliente Corporación Urbana',
                                    'time' => '1 hora',
                                    'completed_at' => 'Hoy, 11:00',
                                    'efficiency' => '88%'
                                ],
                                [
                                    'title' => 'Aprobar órdenes de compra',
                                    'time' => '1.5 horas',
                                    'completed_at' => 'Hoy, 12:45',
                                    'efficiency' => '92%'
                                ],
                                [
                                    'title' => 'Actualizar cronograma proyecto',
                                    'time' => '3 horas',
                                    'completed_at' => 'Hoy, 15:20',
                                    'efficiency' => '85%'
                                ],
                            ];
                        @endphp
                        
                        @foreach($completedTasks as $task)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 text-sm">{{ $task['title'] }}</h4>
                                        <div class="flex items-center space-x-3 mt-1">
                                            <span class="text-xs text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>{{ $task['time'] }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                <i class="fas fa-calendar-check mr-1"></i>{{ $task['completed_at'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-green-600">{{ $task['efficiency'] }}</span>
                                    <p class="text-xs text-gray-500">Eficiencia</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Columna 2: Estado de Productividad y Asignaciones -->
            <div class="space-y-8">
                <!-- Estado de Productividad -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Estado de Productividad</h3>
                    
                    <!-- Gráfico de Productividad -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-600">Productividad Semanal</span>
                            <span class="text-sm font-bold text-blue-600">78%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full" style="width: 78%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-2">
                            <span>Lun: 72%</span>
                            <span>Mar: 75%</span>
                            <span>Mié: 80%</span>
                            <span>Jue: 78%</span>
                            <span>Vie: 82%</span>
                        </div>
                    </div>
                    
                    <!-- Métricas de Tiempo -->
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Tiempo Productivo Hoy</span>
                                <span class="font-bold text-blue-600">6.2h</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 62%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Tasa de Completitud</span>
                                <span class="font-bold text-green-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Puntualidad</span>
                                <span class="font-bold text-yellow-600">73%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 73%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Resumen Diario -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-3">Resumen del Día</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <p class="text-xs text-blue-700">Tareas Iniciadas</p>
                                <p class="text-lg font-bold text-blue-800">5</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <p class="text-xs text-green-700">Completadas</p>
                                <p class="text-lg font-bold text-green-800">8</p>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-lg">
                                <p class="text-xs text-purple-700">Horas Productivas</p>
                                <p class="text-lg font-bold text-purple-800">6.2h</p>
                            </div>
                            <div class="bg-orange-50 p-3 rounded-lg">
                                <p class="text-xs text-orange-700">Eficiencia</p>
                                <p class="text-lg font-bold text-orange-800">78%</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Asignaciones Recibidas -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Asignaciones Recibidas</h3>
                                <p class="text-gray-600 text-sm">Tareas asignadas por otros usuarios</p>
                            </div>
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">3 nuevas</span>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto">
                        @php
                            $assignments = [
                                [
                                    'title' => 'Aprobar diseño estructural',
                                    'assigner' => 'Arq. Laura Martínez',
                                    'time' => '2 horas',
                                    'priority' => 'Alta',
                                    'status' => 'Pendiente'
                                ],
                                [
                                    'title' => 'Revisar propuesta comercial',
                                    'assigner' => 'Director Comercial',
                                    'time' => '1.5 horas',
                                    'priority' => 'Media',
                                    'status' => 'Nueva'
                                ],
                                [
                                    'title' => 'Validar cronograma de obra',
                                    'assigner' => 'Ing. Carlos Ruiz',
                                    'time' => '3 horas',
                                    'priority' => 'Alta',
                                    'status' => 'Nueva'
                                ],
                                [
                                    'title' => 'Firmar autorización de pagos',
                                    'assigner' => 'Contralor',
                                    'time' => '1 hora',
                                    'priority' => 'Media',
                                    'status' => 'Nueva'
                                ],
                            ];
                        @endphp
                        
                        @foreach($assignments as $assignment)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900 text-sm">{{ $assignment['title'] }}</h4>
                                    <div class="flex items-center space-x-3 mt-2">
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-user-tie mr-1"></i>{{ $assignment['assigner'] }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>{{ $assignment['time'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">{{ $assignment['priority'] }}</span>
                                    @if($assignment['status'] == 'Nueva')
                                    <span class="block mt-1 px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $assignment['status'] }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end mt-3 space-x-2">
                                <button class="text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200" onclick="acceptAssignment('{{ $assignment['title'] }}')">
                                    Aceptar
                                </button>
                                <button class="text-xs px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors duration-200" onclick="declineAssignment('{{ $assignment['title'] }}')">
                                    Rechazar
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Notificaciones que Generan Tareas -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Notificaciones</h3>
                                <p class="text-gray-600 text-sm">Pueden convertirse en tareas</p>
                            </div>
                            <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">5 sin leer</span>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto">
                        @php
                            $notifications = [
                                [
                                    'title' => 'Alerta: Retraso en entrega de materiales',
                                    'message' => 'Proveedor reporta retraso de 3 días en acero',
                                    'time' => 'Hace 15 min',
                                    'type' => 'alert',
                                    'can_create_task' => true
                                ],
                                [
                                    'title' => 'Nuevo comentario en proyecto',
                                    'message' => 'Cliente realizó 3 observaciones en planos',
                                    'time' => 'Hace 1 hora',
                                    'type' => 'comment',
                                    'can_create_task' => true
                                ],
                                [
                                    'title' => 'Recordatorio: Reunión trimestral',
                                    'message' => 'Mañana a las 10:00 en sala de juntas',
                                    'time' => 'Hace 2 horas',
                                    'type' => 'reminder',
                                    'can_create_task' => true
                                ],
                                [
                                    'title' => 'Sistema: Actualización completada',
                                    'message' => 'Sistema de gestión actualizado a versión 3.2',
                                    'time' => 'Hace 5 horas',
                                    'type' => 'system',
                                    'can_create_task' => false
                                ],
                            ];
                        @endphp
                        
                        @foreach($notifications as $notification)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start space-x-3">
                                    <div class="mt-1">
                                        @if($notification['type'] == 'alert')
                                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                                        @elseif($notification['type'] == 'comment')
                                        <i class="fas fa-comment text-blue-500"></i>
                                        @elseif($notification['type'] == 'reminder')
                                        <i class="fas fa-bell text-yellow-500"></i>
                                        @else
                                        <i class="fas fa-cog text-gray-500"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 text-sm">{{ $notification['title'] }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $notification['message'] }}</p>
                                        <span class="text-xs text-gray-500 mt-1 block">{{ $notification['time'] }}</span>
                                    </div>
                                </div>
                                @if($notification['can_create_task'])
                                <button class="text-xs px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition-colors duration-200" onclick="createTaskFromNotification('{{ $notification['title'] }}', '{{ $notification['message'] }}')">
                                    Crear Tarea
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Métricas de Rendimiento -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-10">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Métricas de Rendimiento</h3>
                    <p class="text-gray-600 text-sm">Seguimiento de productividad y eficiencia</p>
                </div>
                <select class="bg-gray-100 border-0 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <option>Esta semana</option>
                    <option>Este mes</option>
                    <option>Últimos 3 meses</option>
                    <option>Este año</option>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-sm text-blue-700">Tareas Completadas</p>
                            <p class="text-2xl font-bold text-blue-900">142</p>
                        </div>
                        <i class="fas fa-check-circle text-2xl text-blue-600"></i>
                    </div>
                    <div class="text-sm text-blue-800">
                        <p><i class="fas fa-arrow-up mr-1 text-green-600"></i> +12% vs semana anterior</p>
                        <p class="mt-1">Promedio: 20/día</p>
                    </div>
                </div>
                
                <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-sm text-green-700">Horas Productivas</p>
                            <p class="text-2xl font-bold text-green-900">285h</p>
                        </div>
                        <i class="fas fa-clock text-2xl text-green-600"></i>
                    </div>
                    <div class="text-sm text-green-800">
                        <p><i class="fas fa-arrow-up mr-1 text-green-600"></i> +8% productividad</p>
                        <p class="mt-1">Promedio: 6.2h/día</p>
                    </div>
                </div>
                
                <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-sm text-purple-700">Tasa de Cumplimiento</p>
                            <p class="text-2xl font-bold text-purple-900">88%</p>
                        </div>
                        <i class="fas fa-percentage text-2xl text-purple-600"></i>
                    </div>
                    <div class="text-sm text-purple-800">
                        <p><i class="fas fa-arrow-up mr-1 text-green-600"></i> +5% vs meta</p>
                        <p class="mt-1">Meta: 85%</p>
                    </div>
                </div>
                
                <div class="text-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-sm text-orange-700">Eficiencia General</p>
                            <p class="text-2xl font-bold text-orange-900">82%</p>
                        </div>
                        <i class="fas fa-chart-line text-2xl text-orange-600"></i>
                    </div>
                    <div class="text-sm text-orange-800">
                        <p><i class="fas fa-arrow-up mr-1 text-green-600"></i> +7% optimización</p>
                        <p class="mt-1">Tendencia positiva</p>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico de tendencia -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold text-gray-800">Tendencia de Productividad Semanal</h4>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Leyenda:</span>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-1"></div>
                            <span class="text-xs">Horas</span>
                        </div>
                        <div class="flex items-center ml-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                            <span class="text-xs">Completadas</span>
                        </div>
                    </div>
                </div>
                <div class="h-64 bg-gray-50 rounded-lg p-4">
                    <!-- Gráfico simulado -->
                    <div class="flex items-end h-40 space-x-4">
                        @foreach(['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $day)
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-full flex justify-center space-x-1 mb-2">
                                <div class="w-3 bg-blue-500 rounded-t" style="height: {{ rand(60, 90) }}px"></div>
                                <div class="w-3 bg-green-500 rounded-t" style="height: {{ rand(40, 80) }}px"></div>
                            </div>
                            <span class="text-xs text-gray-600">{{ $day }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-4 px-2">
                        <span>Horas Productivas</span>
                        <span>Tareas Completadas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <p class="text-gray-600 text-base">
                        <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                        Sistema de gestión de tareas y productividad - Actualizado en tiempo real
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Última actualización: {{ now()->format('d/m/Y H:i:s') }} | 
                        Sesión activa: 4h 22m | 
                        <span class="text-green-600"><i class="fas fa-circle text-xs mr-1"></i>Conectado</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm">
                        <i class="fas fa-question-circle mr-2"></i> Ayuda
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm">
                        <i class="fas fa-file-export mr-2"></i> Exportar Reporte
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal para Nueva Tarea -->
<div id="newTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Crear Nueva Tarea</h3>
            <button onclick="closeNewTaskModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="taskForm" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Título de la Tarea</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base" placeholder="¿Qué necesita hacer?" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base" rows="3" placeholder="Describa la tarea en detalle..."></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Proyecto Asociado</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                        <option value="">Seleccionar proyecto</option>
                        <option value="torre-norte">Torre Norte</option>
                        <option value="plaza-central">Plaza Central</option>
                        <option value="villas-norte">Villas del Norte</option>
                        <option value="parque-industrial">Parque Industrial Norte</option>
                        <option value="administracion">Administración</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                        <option value="low">Baja</option>
                        <option value="medium" selected>Media</option>
                        <option value="high">Alta</option>
                        <option value="urgent">Urgente</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Límite</label>
                    <input type="datetime-local" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo Estimado</label>
                    <div class="flex space-x-2">
                        <input type="number" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base" placeholder="Horas" min="0.5" step="0.5">
                        <select class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                            <option value="hours">Horas</option>
                            <option value="days">Días</option>
                            <option value="weeks">Semanas</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
                <div class="flex flex-wrap gap-2">
                    <input type="text" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base" placeholder="Añadir etiquetas (presiona Enter)">
                </div>
                <div class="mt-2">
                    <span class="text-xs text-gray-500">Etiquetas sugeridas: Revisión, Análisis, Reunión, Reporte, Presupuesto</span>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Asignar a</label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                    <option value="">Auto-asignar</option>
                    <option value="team">Equipo de Construcción</option>
                    <option value="design">Equipo de Diseño</option>
                    <option value="purchasing">Equipo de Compras</option>
                    <option value="supervision">Equipo de Supervisión</option>
                </select>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="notification" class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500">
                <label for="notification" class="ml-2 text-sm text-gray-700">Crear recordatorio de notificación</label>
            </div>
            
            <div class="pt-6 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeNewTaskModal()" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200 text-base">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-base">
                    <i class="fas fa-plus mr-2"></i> Crear Tarea
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
// Funciones para el modal de nueva tarea
function openNewTaskModal() {
    const modal = document.getElementById('newTaskModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeNewTaskModal() {
    const modal = document.getElementById('newTaskModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

// Funciones para filtrado de tareas
function filterTasks(filterType) {
    const taskItems = document.querySelectorAll('.task-item');
    
    taskItems.forEach(item => {
        switch(filterType) {
            case 'all':
                item.style.display = 'block';
                break;
            case 'high':
                if (item.dataset.priority === 'high') {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
                break;
            case 'today':
                if (item.dataset.status === 'overdue' || item.dataset.status === 'in_progress') {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
                break;
        }
    });
}

// Funciones de acciones de tareas
function completeTask(taskId) {
    if (confirm('¿Marcar esta tarea como completada?')) {
        alert(`Tarea ${taskId} marcada como completada.`);
        // Aquí iría la lógica para actualizar el estado en el backend
    }
}

function editTask(taskId) {
    alert(`Editando tarea ${taskId}...`);
    openNewTaskModal();
    // Aquí se cargarían los datos de la tarea en el modal
}

function startTask(taskId) {
    if (confirm('¿Comenzar a trabajar en esta tarea?')) {
        alert(`Tarea ${taskId} iniciada. Se iniciará el temporizador.`);
        // Aquí iría la lógica para iniciar el temporizador
    }
}

function deleteTask(taskId) {
    if (confirm('¿Está seguro de eliminar esta tarea?')) {
        alert(`Tarea ${taskId} eliminada.`);
        // Aquí iría la lógica para eliminar la tarea
    }
}

function loadMoreTasks() {
    alert('Cargando más tareas...');
    // Aquí iría la lógica para cargar más tareas
}

function showCompletedTasks() {
    alert('Mostrando todas las tareas completadas...');
    // Aquí iría la lógica para mostrar todas las completadas
}

// Funciones para asignaciones
function acceptAssignment(title) {
    if (confirm(`¿Aceptar la asignación "${title}"?`)) {
        alert(`Asignación "${title}" aceptada y agregada a sus tareas.`);
        // Aquí iría la lógica para aceptar la asignación
    }
}

function declineAssignment(title) {
    if (confirm(`¿Rechazar la asignación "${title}"?`)) {
        alert(`Asignación "${title}" rechazada.`);
        // Aquí iría la lógica para rechazar la asignación
    }
}

// Funciones para notificaciones
function createTaskFromNotification(title, message) {
    alert(`Creando tarea desde notificación: ${title}`);
    openNewTaskModal();
    // Aquí se pre-llenaría el formulario con los datos de la notificación
}

// Manejo del formulario de nueva tarea
document.getElementById('taskForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Tarea creada exitosamente');
    closeNewTaskModal();
    // Aquí iría la lógica para enviar el formulario al backend
});

// Simulación de actualización en tiempo real
function updateLiveData() {
    const timeElements = document.querySelectorAll('.real-time-data');
    timeElements.forEach(el => {
        const current = parseFloat(el.textContent);
        if (!isNaN(current)) {
            const change = (Math.random() - 0.5) * 0.1;
            const newValue = Math.max(0, current + change);
            el.textContent = newValue.toFixed(1);
        }
    });
}

// Actualizar cada 60 segundos
setInterval(updateLiveData, 60000);

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    // Aquí se pueden inicializar más funciones si es necesario
});
</script>

<style>
/* Estilos personalizados para la página de tareas */
.task-item {
    transition: all 0.2s ease;
}

.task-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Scrollbar personalizado */
.max-h-\[500px\]::-webkit-scrollbar {
    width: 6px;
}

.max-h-\[500px\]::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.max-h-\[500px\]::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.max-h-\[500px\]::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

#newTaskModal {
    animation: fadeIn 0.3s ease;
}

/* Estilos para estados de tareas */
.task-status-pending {
    border-left: 4px solid #f59e0b;
}

.task-status-in_progress {
    border-left: 4px solid #3b82f6;
}

.task-status-overdue {
    border-left: 4px solid #ef4444;
}

.task-status-completed {
    border-left: 4px solid #10b981;
}

/* Efecto de completado */
input[type="checkbox"]:checked + .task-title {
    text-decoration: line-through;
    color: #9ca3af;
}

/* Responsive */
@media (max-width: 768px) {
    .task-actions {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .task-info {
        flex-direction: column;
        gap: 0.5rem;
    }
}

/* Estilo para notificaciones */
.notification-alert {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Mejoras de accesibilidad */
:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Transiciones suaves */
button, a {
    transition: all 0.2s ease;
}
</style>
@endsection