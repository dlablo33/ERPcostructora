@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 pt-4">
    <!-- Header del módulo -->
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Soporte Técnico</h1>
                        <p class="text-yellow-100 text-sm">Centro de atención y gestión de tickets</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 mt-3 md:mt-0">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm flex items-center">
                        <i class="fas fa-circle text-green-400 text-xs mr-2"></i>
                        En línea
                    </span>
                    <a href="{{ route('soporte.faq') }}" class="px-4 py-2 bg-white text-yellow-600 rounded-lg hover:bg-yellow-50 transition flex items-center text-sm font-medium">
                        <i class="fas fa-question-circle mr-2"></i> Ayuda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('soporte-content')
    </div>
</div>
@endsection