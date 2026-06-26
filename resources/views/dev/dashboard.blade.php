@extends('dev.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Bienvenida -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">¡Bienvenido, {{ session('dev_nombre') }}!</h1>
        <p class="text-gray-600 mt-1">Aquí puedes gestionar todos los tickets asignados a ti.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Asignados</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-tasks text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pendientes'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">En Desarrollo</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['en_desarrollo'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-spinner text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Completados</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['completados'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Tickets -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">📋 Mis Tickets</h2>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($tickets as $ticket)
            <div class="px-6 py-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-center">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <h3 class="font-medium text-gray-800">
                                <a href="{{ route('dev.tickets.show', $ticket->id) }}" class="hover:text-blue-600">
                                    #{{ $ticket->id }} - {{ $ticket->titulo }}
                                </a>
                            </h3>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $ticket->prioridad == 'critica' ? 'bg-red-100 text-red-800' : 
                                   ($ticket->prioridad == 'alta' ? 'bg-orange-100 text-orange-800' :
                                   ($ticket->prioridad == 'media' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-green-100 text-green-800')) }}">
                                {{ ucfirst($ticket->prioridad) }}
                            </span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $ticket->estado == 'en_desarrollo' ? 'bg-blue-100 text-blue-800' :
                                   ($ticket->estado == 'completado' ? 'bg-green-100 text-green-800' :
                                   ($ticket->estado == 'aprobado' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $ticket->created_at->format('d/m/Y') }}
                            </span>
                            @if($ticket->tiempo_estimado)
                            <span>
                                <i class="far fa-clock mr-1"></i>
                                Estimado: {{ $ticket->tiempo_estimado }}h
                            </span>
                            @endif
                            @if($ticket->tiempo_real)
                            <span>
                                <i class="fas fa-check-circle mr-1 text-green-500"></i>
                                Real: {{ $ticket->tiempo_real }}h
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @if($ticket->estado == 'aprobado')
                        <form method="POST" action="{{ route('dev.tickets.start', $ticket->id) }}" 
                              onsubmit="return confirmAction('¿Iniciar desarrollo de este ticket?')">
                            @csrf
                            <button type="submit" 
                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                <i class="fas fa-play mr-1"></i> Iniciar
                            </button>
                        </form>
                        @endif

                        @if($ticket->estado == 'en_desarrollo')
                        <form method="POST" action="{{ route('dev.tickets.complete', $ticket->id) }}"
                              onsubmit="return confirmAction('¿Completar este ticket?')">
                            @csrf
                            <button type="submit" 
                                    class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                <i class="fas fa-check mr-1"></i> Completar
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('dev.tickets.show', $ticket->id) }}" 
                           class="px-3 py-1 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300 transition">
                            <i class="fas fa-eye mr-1"></i> Ver
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-6 py-12 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3 block text-gray-300"></i>
                <p>No tienes tickets asignados.</p>
                <p class="text-sm mt-1">Los tickets te serán asignados por el equipo de soporte.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection