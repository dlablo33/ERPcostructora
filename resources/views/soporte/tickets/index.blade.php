@extends('soporte.layouts.app')

@section('soporte-content')
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border-b border-yellow-200">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-ticket-alt text-yellow-600 mr-2"></i> Mis Tickets
                </h3>
                <p class="text-sm text-gray-600">Gestiona todas tus solicitudes de soporte</p>
            </div>
            <div class="flex space-x-2 mt-3 md:mt-0">
                <a href="{{ route('soporte.tickets.create') }}" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition text-sm flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nuevo Ticket
                </a>
                <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition text-sm flex items-center">
                    <i class="fas fa-sync-alt mr-2"></i> Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-sm text-gray-600 font-medium">Filtros:</span>
            <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="en_revision">En Revisión</option>
                <option value="en_desarrollo">En Desarrollo</option>
                <option value="completado">Completado</option>
                <option value="rechazado">Rechazado</option>
            </select>
            <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="">Todas las prioridades</option>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="critica">Crítica</option>
            </select>
            <div class="flex-1"></div>
            <span class="text-sm text-gray-500">Mostrando 0 tickets</span>
        </div>
    </div>

    <!-- Lista de Tickets -->
    <div class="divide-y divide-gray-200" id="tickets-list">
        <!-- Ticket de ejemplo 1 -->
        <div class="p-6 hover:bg-gray-50 transition group">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex items-start space-x-4 flex-1">
                    <div class="mt-1">
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="font-medium text-gray-800 hover:text-yellow-600">
                                <a href="{{ route('soporte.tickets.show', 1) }}">Error al generar factura #12345</a>
                            </h4>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Alta</span>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">En Revisión</span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Error</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                            El sistema no permite generar facturas cuando el cliente tiene más de 3 facturas pendientes...
                        </p>
                        <div class="flex flex-wrap items-center gap-4 mt-2 text-xs text-gray-500">
                            <span><i class="far fa-calendar-alt mr-1"></i> Creado: 25/06/2024</span>
                            <span><i class="far fa-user mr-1"></i> Juan Pérez</span>
                            <span><i class="far fa-clock mr-1"></i> Hace 2 horas</span>
                            <span class="text-green-600"><i class="fas fa-comment mr-1"></i> 3 comentarios</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 mt-3 md:mt-0">
                    <a href="{{ route('soporte.tickets.show', 1) }}" class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                        <i class="fas fa-eye mr-1"></i> Ver
                    </a>
                    <button class="px-3 py-1 text-sm bg-gray-50 text-gray-600 rounded hover:bg-gray-100 transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Ticket de ejemplo 2 -->
        <div class="p-6 hover:bg-gray-50 transition group">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex items-start space-x-4 flex-1">
                    <div class="mt-1">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="font-medium text-gray-800 hover:text-yellow-600">
                                <a href="{{ route('soporte.tickets.show', 2) }}">Mejora en el dashboard de ventas</a>
                            </h4>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Media</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Completado</span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Mejora</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                            Agregar gráficos interactivos y filtros avanzados en el dashboard de ventas...
                        </p>
                        <div class="flex flex-wrap items-center gap-4 mt-2 text-xs text-gray-500">
                            <span><i class="far fa-calendar-alt mr-1"></i> Creado: 24/06/2024</span>
                            <span><i class="far fa-user mr-1"></i> María García</span>
                            <span><i class="far fa-clock mr-1"></i> Hace 1 día</span>
                            <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Resuelto</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 mt-3 md:mt-0">
                    <a href="{{ route('soporte.tickets.show', 2) }}" class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                        <i class="fas fa-eye mr-1"></i> Ver
                    </a>
                    <button class="px-3 py-1 text-sm bg-gray-50 text-gray-600 rounded hover:bg-gray-100 transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Ticket de ejemplo 3 -->
        <div class="p-6 hover:bg-gray-50 transition group">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex items-start space-x-4 flex-1">
                    <div class="mt-1">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="font-medium text-gray-800 hover:text-yellow-600">
                                <a href="{{ route('soporte.tickets.show', 3) }}">Error crítico en el login</a>
                            </h4>
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Crítica</span>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Pendiente</span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Error</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                            Los usuarios no pueden iniciar sesión, el sistema muestra un error de autenticación...
                        </p>
                        <div class="flex flex-wrap items-center gap-4 mt-2 text-xs text-gray-500">
                            <span><i class="far fa-calendar-alt mr-1"></i> Creado: Hoy</span>
                            <span><i class="far fa-user mr-1"></i> Carlos López</span>
                            <span><i class="far fa-clock mr-1"></i> Hace 30 min</span>
                            <span class="text-red-600"><i class="fas fa-exclamation-circle mr-1"></i> Urgente</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 mt-3 md:mt-0">
                    <a href="{{ route('soporte.tickets.show', 3) }}" class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                        <i class="fas fa-eye mr-1"></i> Ver
                    </a>
                    <button class="px-3 py-1 text-sm bg-gray-50 text-gray-600 rounded hover:bg-gray-100 transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex flex-wrap justify-between items-center">
            <span class="text-sm text-gray-600">Mostrando 1-3 de 12 tickets</span>
            <div class="flex space-x-1">
                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100 transition disabled:opacity-50" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">1</button>
                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100 transition">2</button>
                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100 transition">3</button>
                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100 transition">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection