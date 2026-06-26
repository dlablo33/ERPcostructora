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
                                <span class="text-lg text-gray-600">Bienvenido, <span class="font-semibold text-blue-800">{{ Auth::user()->name }}</span></span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    {{ $stats['total'] }} tareas asignadas
                                </span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 max-w-3xl text-base">
                        Gestiona tus tareas asignadas y da seguimiento a las actividades del sistema.
                        @if($stats['pending'] > 0)
                            <span class="text-yellow-600 font-medium">Tienes {{ $stats['pending'] }} tareas pendientes.</span>
                        @endif
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex gap-3">
                        <div class="relative">
                            <select id="filterSelect" class="appearance-none bg-white border border-gray-300 rounded-lg py-3 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-sm text-base" onchange="applyFilters()">
                                <option value="all">Todas</option>
                                <option value="pending">Pendientes</option>
                                <option value="in_progress">En Progreso</option>
                                <option value="completed">Completadas</option>
                                <option value="overdue">Vencidas</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <select id="priorityFilter" class="appearance-none bg-white border border-gray-300 rounded-lg py-3 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-sm text-base" onchange="applyFilters()">
                                <option value="">Todas las prioridades</option>
                                <option value="high">Alta</option>
                                <option value="medium">Media</option>
                                <option value="low">Baja</option>
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
            <div id="taskStats" class="mt-8 flex flex-wrap gap-3">
                <div class="flex-1 min-w-[120px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <i class="fas fa-list text-3xl text-blue-600 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[120px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Pendientes</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                        </div>
                        <i class="fas fa-clock text-3xl text-yellow-500 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[120px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">En Progreso</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
                        </div>
                        <i class="fas fa-spinner text-3xl text-blue-500 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[120px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Completadas</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-500 opacity-70"></i>
                    </div>
                </div>
                
                <div class="flex-1 min-w-[120px] bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Vencidas</p>
                            <p class="text-2xl font-bold text-red-600">{{ $stats['overdue'] }}</p>
                        </div>
                        <i class="fas fa-exclamation-circle text-3xl text-red-500 opacity-70"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección Principal: Tareas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Columna 1: Lista de Tareas -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-gray-50">
                        <div class="flex justify-between items-center flex-wrap gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Mis Tareas</h3>
                                <p id="taskCounter" class="text-gray-600 text-sm">
                                    {{ $stats['pending'] }} tarea{{ $stats['pending'] != 1 ? 's' : '' }} pendiente{{ $stats['pending'] != 1 ? 's' : '' }}
                                </p>
                            </div>
                            <div class="flex gap-2 flex-wrap">
                                <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors duration-200" onclick="filterTasks('all')">
                                    Todas
                                </button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="filterTasks('pending')">
                                    Pendientes
                                </button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="filterTasks('in_progress')">
                                    En Progreso
                                </button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="filterTasks('completed')">
                                    Completadas
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="taskList" class="divide-y divide-gray-200 max-h-[600px] overflow-y-auto">
                        <!-- Las tareas se renderizan desde el backend -->
                        @forelse($tasks as $task)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-150 task-item" 
                             data-id="{{ $task->id }}" 
                             data-status="{{ $task->status }}"
                             data-priority="{{ $task->priority }}"
                             data-module="{{ $task->module }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3 flex-1">
                                    <div class="mt-1">
                                        <input type="checkbox" 
                                               class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500 task-checkbox" 
                                               {{ $task->status == 'completed' ? 'checked' : '' }} 
                                               onchange="toggleTask({{ $task->id }})"
                                               {{ $task->status == 'completed' ? 'disabled' : '' }}>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-medium text-gray-900 text-base {{ $task->status == 'completed' ? 'line-through text-gray-400' : '' }}">
                                                    {{ $task->title }}
                                                    @if($task->module == 'requisiciones')
                                                        <span class="ml-2 text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full inline-block">
                                                            <i class="fas fa-file-invoice mr-1"></i> Requisición
                                                        </span>
                                                    @elseif($task->module == 'cotizaciones')
                                                        <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full inline-block">
                                                            <i class="fas fa-file-pdf mr-1"></i> Cotización
                                                        </span>
                                                    @elseif($task->module == 'orden_compra')
                                                        <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full inline-block">
                                                            <i class="fas fa-shopping-cart mr-1"></i> Orden Compra
                                                        </span>
                                                    @endif
                                                </h4>
                                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($task->description ?? 'Sin descripción', 150) }}</p>
                                            </div>
                                            <div class="flex items-center space-x-2 flex-shrink-0">
                                                <span class="px-2 py-1 {{ $task->status == 'completed' ? 'bg-green-100 text-green-800' : ($task->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : ($task->status == 'overdue' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }} rounded-full text-xs font-medium">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                                <span class="px-2 py-1 {{ $task->priority == 'high' ? 'bg-red-100 text-red-800' : ($task->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }} rounded-full text-xs font-medium">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center mt-3 space-x-4 flex-wrap">
                                            @if($task->due_date)
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-day mr-1 text-blue-500"></i>
                                                <span class="{{ $task->due_date < now() && $task->status != 'completed' ? 'text-red-600 font-medium' : '' }}">
                                                    {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                                    @if($task->due_date < now() && $task->status != 'completed')
                                                        <span class="text-red-600 ml-1">(Vencida)</span>
                                                    @endif
                                                </span>
                                            </div>
                                            @endif
                                            
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-user mr-1 text-gray-400"></i>
                                                <span>Asignada a: {{ $task->assignedUser->name ?? 'N/A' }}</span>
                                            </div>
                                            
                                            @if($task->created_at)
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="fas fa-clock mr-1 text-gray-400"></i>
                                                <span>Creada: {{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Acción requerida si es de requisición -->
                                        @if($task->metadata && isset($task->metadata['tipo']))
                                            @php $metadata = $task->metadata; @endphp
                                            @if($metadata['tipo'] == 'orden_compra' || $metadata['tipo'] == 'requisicion_creada')
                                            <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                                <div class="flex items-center text-sm text-blue-800">
                                                    <i class="fas fa-info-circle mr-2"></i>
                                                    <span>
                                                        <strong>Acción requerida:</strong> 
                                                        @if($metadata['tipo'] == 'orden_compra')
                                                            Crear Orden de Compra
                                                            @if(isset($metadata['folio_requisicion']))
                                                                para requisición {{ $metadata['folio_requisicion'] }}
                                                            @endif
                                                        @else
                                                            Revisar requisición
                                                            @if(isset($metadata['folio']))
                                                                {{ $metadata['folio'] }}
                                                            @endif
                                                        @endif
                                                        @if(isset($metadata['requisicion_id']))
                                                            <a href="{{ route('compras.requisiciones.show', $metadata['requisicion_id']) }}" 
                                                               class="text-blue-600 hover:underline ml-2">
                                                                <i class="fas fa-external-link-alt"></i> Ver detalles
                                                            </a>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="ml-4 flex items-center space-x-2 flex-shrink-0">
                                    @if($task->status != 'completed')
                                    <button class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200" 
                                            title="Marcar como completada" 
                                            onclick="completeTask({{ $task->id }})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                            title="Iniciar tarea" 
                                            onclick="startTask({{ $task->id }})">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    @endif
                                    <button class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                            title="Eliminar" 
                                            onclick="confirmDelete({{ $task->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <div class="text-gray-400 text-6xl mb-4">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-600 mb-2">No hay tareas asignadas</h3>
                            <p class="text-gray-500">Las tareas se generan automáticamente desde requisiciones, cotizaciones y otros módulos.</p>
                            <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" onclick="openNewTaskModal()">
                                <i class="fas fa-plus mr-2"></i> Crear tarea manual
                            </button>
                        </div>
                        @endforelse
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center flex-wrap gap-2">
                            <span id="taskCountDisplay" class="text-sm text-gray-600">
                                Mostrando {{ $tasks->count() }} tarea{{ $tasks->count() != 1 ? 's' : '' }}
                                de {{ $stats['total'] }} totales
                            </span>
                            <div class="flex items-center space-x-2">
                                <button class="text-sm text-blue-800 hover:text-blue-900 font-medium" onclick="loadMoreTasks()">
                                    <i class="fas fa-redo mr-1"></i> Recargar
                                </button>
                                @if($tasks->hasPages())
                                    {{ $tasks->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Columna 2: Panel de Control -->
            <div class="space-y-8">
                <!-- Estado de Productividad -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-50 to-gray-50">
                        <h3 class="text-xl font-bold text-gray-900">Estado de Productividad</h3>
                    </div>
                    <div class="p-6">
                        <div id="productivityStats">
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">Progreso General</span>
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0 }}%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-500" 
                                         style="width: {{ $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0 }}%">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="text-xs text-gray-500">Pendientes</p>
                                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="text-xs text-gray-500">En Progreso</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="text-xs text-gray-500">Completadas</p>
                                    <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="text-xs text-gray-500">Vencidas</p>
                                    <p class="text-2xl font-bold text-red-600">{{ $stats['overdue'] }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ $stats['total'] }} tarea{{ $stats['total'] != 1 ? 's' : '' }} en total
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tareas por Módulo -->
                @if(!empty($stats['by_module']))
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-gray-50">
                        <h3 class="text-xl font-bold text-gray-900">Tareas por Módulo</h3>
                    </div>
                    <div class="p-4 divide-y divide-gray-200">
                        @foreach($stats['by_module'] as $module => $count)
                        <div class="py-2 flex justify-between items-center">
                            <span class="text-sm text-gray-700">
                                <i class="fas {{ $module == 'requisiciones' ? 'fa-file-invoice' : ($module == 'cotizaciones' ? 'fa-file-pdf' : 'fa-tasks') }} mr-2 text-gray-400"></i>
                                {{ ucfirst($module) }}
                            </span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Notificaciones -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Notificaciones</h3>
                                <p class="text-gray-600 text-sm">Tareas recientes</p>
                            </div>
                            <span id="notificationBadge" class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                                {{ $tasks->where('status', 'pending')->count() }}
                            </span>
                        </div>
                    </div>
                    
                    <div id="notificationsContainer" class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto">
                        @php
                            $recentTasks = $tasks->where('status', '!=', 'completed')->take(5);
                        @endphp
                        
                        @forelse($recentTasks as $task)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-start space-x-3">
                                <div class="mt-1">
                                    <i class="fas {{ $task->priority == 'high' ? 'fa-exclamation-triangle text-red-500' : 'fa-info-circle text-blue-500' }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 text-sm">{{ Str::limit($task->title, 50) }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }}
                                    </p>
                                    @if($task->due_date)
                                    <p class="text-xs {{ $task->due_date < now() ? 'text-red-600' : 'text-gray-500' }} mt-1">
                                        <i class="fas fa-calendar mr-1"></i>
                                        Vence: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                    </p>
                                    @endif
                                </div>
                                @if($task->status != 'completed')
                                <button class="text-xs px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors" 
                                        onclick="completeTask({{ $task->id }})">
                                    Completar
                                </button>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-gray-500">
                            <i class="fas fa-check-circle text-green-500 text-2xl mb-2 block"></i>
                            <p class="text-sm">No hay notificaciones pendientes</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<!-- Modal para Nueva Tarea -->
<div id="newTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Crear Nueva Tarea</h3>
            <button onclick="closeNewTaskModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="taskForm" class="space-y-6" onsubmit="saveTask(event)">
            <input type="hidden" id="taskId" value="">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Título de la Tarea *</label>
                <input type="text" id="taskTitle" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base" placeholder="¿Qué necesita hacer?" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea id="taskDescription" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base" rows="3" placeholder="Describa la tarea en detalle..."></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                    <select id="taskPriority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                        <option value="low">Baja</option>
                        <option value="medium" selected>Media</option>
                        <option value="high">Alta</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Límite</label>
                    <input type="date" id="taskDueDate" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Módulo (opcional)</label>
                <select id="taskModule" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base">
                    <option value="">Sin módulo específico</option>
                    <option value="requisiciones">Requisiciones</option>
                    <option value="cotizaciones">Cotizaciones</option>
                    <option value="proyectos">Proyectos</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
                <input type="text" id="taskTags" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base" placeholder="Ej: Desarrollo, Revisión, Urgente">
            </div>
            
            <div class="pt-6 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeNewTaskModal()" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200 text-base">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-base">
                    <i class="fas fa-save mr-2"></i> <span id="submitButtonText">Crear Tarea</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Confirmación -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">¿Estás seguro?</h3>
            <p id="confirmMessage" class="text-gray-600 mb-6">Esta acción no se puede deshacer.</p>
            <div class="flex justify-center space-x-3">
                <button onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Cancelar
                </button>
                <button id="confirmActionBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ============================================
// CONFIGURACIÓN - CSRF Token
// ============================================
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

// ============================================
// FUNCIONES DE API
// ============================================

/**
 * Completa una tarea
 */
function completeTask(taskId) {
    if (!confirm('¿Marcar esta tarea como completada?')) return;
    
    fetch(`/workflow/tareas/${taskId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('✅ Tarea completada exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('❌ ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('❌ Error al completar la tarea', 'error');
        console.error('Error:', error);
    });
}

/**
 * Inicia una tarea (marca como en progreso)
 */
function startTask(taskId) {
    if (!confirm('¿Comenzar a trabajar en esta tarea?')) return;
    
    fetch(`/workflow/tareas/${taskId}/start`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('▶️ Tarea iniciada', 'info');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('❌ ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('❌ Error al iniciar la tarea', 'error');
        console.error('Error:', error);
    });
}

/**
 * Elimina una tarea
 */
function deleteTask(id) {
    fetch(`/workflow/tareas/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('🗑️ Tarea eliminada', 'info');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('❌ ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('❌ Error al eliminar la tarea', 'error');
        console.error('Error:', error);
    });
}

/**
 * Guarda una tarea nueva o actualizada
 */
function saveTask(event) {
    event.preventDefault();
    
    const id = document.getElementById('taskId').value;
    const title = document.getElementById('taskTitle').value.trim();
    
    if (!title) {
        showNotification('⚠️ El título es obligatorio', 'warning');
        return;
    }
    
    const taskData = {
        title: title,
        description: document.getElementById('taskDescription').value.trim(),
        priority: document.getElementById('taskPriority').value,
        due_date: document.getElementById('taskDueDate').value,
        module: document.getElementById('taskModule').value,
        tags: document.getElementById('taskTags').value.split(',').map(t => t.trim()).filter(t => t)
    };
    
    const url = id ? `/workflow/tareas/${id}` : '/workflow/tareas';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(taskData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(id ? '✅ Tarea actualizada' : '✅ Tarea creada', 'success');
            closeNewTaskModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('❌ ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('❌ Error al guardar la tarea', 'error');
        console.error('Error:', error);
    });
}

/**
 * Filtra tareas por estado
 */
function filterTasks(filter) {
    const taskItems = document.querySelectorAll('.task-item');
    let visibleCount = 0;
    
    taskItems.forEach(item => {
        const status = item.dataset.status;
        if (filter === 'all' || status === filter) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Actualizar contador
    document.getElementById('taskCountDisplay').textContent = 
        `Mostrando ${visibleCount} tarea${visibleCount !== 1 ? 's' : ''}`;
}

/**
 * Aplica filtros combinados (estado + prioridad)
 */
function applyFilters() {
    const statusFilter = document.getElementById('filterSelect').value;
    const priorityFilter = document.getElementById('priorityFilter').value;
    const taskItems = document.querySelectorAll('.task-item');
    let visibleCount = 0;
    
    taskItems.forEach(item => {
        const status = item.dataset.status;
        const priority = item.dataset.priority;
        let show = true;
        
        if (statusFilter !== 'all' && status !== statusFilter) {
            show = false;
        }
        
        if (priorityFilter && priority !== priorityFilter) {
            show = false;
        }
        
        if (show) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    document.getElementById('taskCountDisplay').textContent = 
        `Mostrando ${visibleCount} tarea${visibleCount !== 1 ? 's' : ''}`;
}

/**
 * Recarga las tareas
 */
function loadMoreTasks() {
    location.reload();
}

// ============================================
// NOTIFICACIONES
// ============================================

function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500',
        error: 'bg-red-500'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type] || 'bg-gray-500'} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full max-w-md`;
    notification.innerHTML = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 4000);
}

// ============================================
// Toggle de Tarea (checkbox)
// ============================================

function toggleTask(taskId) {
    // Esta función maneja el checkbox, pero la acción real se hace con completeTask
    const checkbox = event.target;
    if (checkbox.checked) {
        completeTask(taskId);
    }
}

// ============================================
// MODALES
// ============================================

function openNewTaskModal() {
    document.getElementById('modalTitle').textContent = 'Crear Nueva Tarea';
    document.getElementById('submitButtonText').textContent = 'Crear Tarea';
    document.getElementById('taskId').value = '';
    document.getElementById('taskForm').reset();
    document.getElementById('taskDueDate').value = new Date().toISOString().split('T')[0];
    
    const modal = document.getElementById('newTaskModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeNewTaskModal() {
    const modal = document.getElementById('newTaskModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

function confirmDelete(id) {
    const taskItem = document.querySelector(`.task-item[data-id="${id}"]`);
    const title = taskItem?.querySelector('h4')?.textContent?.trim() || 'esta tarea';
    
    document.getElementById('confirmMessage').textContent = `¿Estás seguro de eliminar la tarea "${title}"? Esta acción no se puede deshacer.`;
    document.getElementById('confirmActionBtn').onclick = function() {
        deleteTask(id);
        closeConfirmModal();
    };
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

// ============================================
// INICIALIZACIÓN
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Cerrar modales con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNewTaskModal();
            closeConfirmModal();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('newTaskModal').addEventListener('click', function(e) {
        if (e.target === this) closeNewTaskModal();
    });
    
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirmModal();
    });
    
    console.log('✅ Panel de tareas cargado exitosamente');
    console.log(`📋 ${document.querySelectorAll('.task-item').length} tareas mostradas`);
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
.max-h-\[600px\]::-webkit-scrollbar {
    width: 6px;
}

.max-h-\[600px\]::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.max-h-\[600px\]::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.max-h-\[600px\]::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

#newTaskModal, #confirmModal {
    animation: fadeIn 0.3s ease;
}

/* Transiciones suaves */
button, a {
    transition: all 0.2s ease;
}

/* Línea de texto truncada */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Badge de módulo */
.task-item .bg-purple-100,
.task-item .bg-blue-100,
.task-item .bg-green-100 {
    display: inline-block;
}
</style>
@endsection