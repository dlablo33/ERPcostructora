@extends('soporte.layouts.app')

@section('soporte-content')
<div class="max-w-4xl mx-auto">
    <!-- Botón volver -->
    <a href="{{ route('soporte.tickets.index') }}" class="inline-flex items-center text-gray-600 hover:text-yellow-600 mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Volver a mis tickets
    </a>

    <!-- Ticket -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border-b border-yellow-200">
            <div class="flex flex-wrap justify-between items-start gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold text-gray-800">#123 - Error al generar factura</h3>
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Alta</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">En Revisión</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Creado por Juan Pérez · 25/06/2024 · Hace 2 horas</p>
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </button>
                    <button class="px-3 py-1 text-sm bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition">
                        <i class="fas fa-trash mr-1"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="p-6">
            <!-- Info del ticket -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-xs text-gray-500">Tipo</p>
                    <p class="font-medium text-gray-800">🐛 Error</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Prioridad</p>
                    <p class="font-medium text-red-600">🔴 Alta</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Estado</p>
                    <p class="font-medium text-blue-600">📋 En Revisión</p>
                </div>
            </div>

            <!-- Descripción -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-800 mb-2">📝 Descripción</h4>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-700 text-sm leading-relaxed">
                    El sistema no permite generar facturas cuando el cliente tiene más de 3 facturas pendientes. 
                    El error ocurre al intentar timbrar la factura, mostrando un mensaje de "Límite de facturas 
                    pendientes excedido" aunque el cliente ya ha pagado las facturas anteriores.
                </div>
            </div>

            <!-- Archivos adjuntos -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-800 mb-2">📎 Archivos adjuntos</h4>
                <div class="flex flex-wrap gap-2">
                    <a href="#" class="flex items-center px-3 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition text-sm">
                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                        error_log.txt
                        <span class="text-xs text-gray-500 ml-2">(2.3 KB)</span>
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition text-sm">
                        <i class="fas fa-image text-blue-500 mr-2"></i>
                        screenshot_error.png
                        <span class="text-xs text-gray-500 ml-2">(1.2 MB)</span>
                    </a>
                </div>
            </div>

            <!-- Comentarios -->
            <div>
                <h4 class="font-semibold text-gray-800 mb-4">💬 Comentarios</h4>
                
                <!-- Comentario 1 -->
                <div class="flex items-start space-x-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div class="flex-1 bg-gray-50 rounded-lg p-3">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-800">Soporte Técnico</span>
                            <span class="text-xs text-gray-500">Hace 1 hora</span>
                        </div>
                        <p class="text-sm text-gray-700 mt-1">
                            Hemos revisado el error y parece estar relacionado con la validación de crédito del cliente. 
                            Estamos trabajando en una solución.
                        </p>
                    </div>
                </div>

                <!-- Comentario 2 -->
                <div class="flex items-start space-x-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-green-600"></i>
                    </div>
                    <div class="flex-1 bg-gray-50 rounded-lg p-3">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-800">Juan Pérez (Cliente)</span>
                            <span class="text-xs text-gray-500">Hace 30 min</span>
                        </div>
                        <p class="text-sm text-gray-700 mt-1">
                            Gracias por la respuesta. ¿Tienen una estimación de cuándo estará listo?
                        </p>
                    </div>
                </div>

                <!-- Agregar comentario -->
                <div class="mt-4">
                    <form class="flex items-start space-x-3" onsubmit="event.preventDefault(); alert('Comentario agregado (Demo)');">
                        <div class="flex-1">
                            <textarea rows="2" placeholder="Agregar un comentario..." 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition text-sm"></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition flex-shrink-0">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection