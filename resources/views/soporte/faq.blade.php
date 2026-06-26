@extends('soporte.layouts.app')

@section('soporte-content')
<!-- Banner de bienvenida -->
<div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-yellow-100">
    <div class="text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-headset text-4xl text-white"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido al Centro de Soporte</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Aquí podrás encontrar ayuda, tutoriales y gestionar tus solicitudes de soporte técnico.
        </p>
        <div class="flex flex-wrap justify-center gap-3 mt-4">
            <button onclick="navigateTo('Nuevo Ticket', 'soporte', '{{ route('soporte.tickets.create') }}', 'fa-plus-circle')" 
        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition text-sm flex items-center">
    <i class="fas fa-plus mr-2"></i> Nuevo Ticket
</button>
            <a href="{{ route('soporte.tickets.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition flex items-center">
                <i class="fas fa-list mr-2"></i> Ver Mis Tickets
            </a>
        </div>
    </div>
</div>

<!-- Estadísticas rápidas -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Tickets</p>
                <p class="text-2xl font-bold text-gray-800">12</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pendientes</p>
                <p class="text-2xl font-bold text-yellow-600">3</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Resueltos</p>
                <p class="text-2xl font-bold text-green-600">7</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Tiempo Promedio</p>
                <p class="text-2xl font-bold text-purple-600">2.5h</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-hourglass-half text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Preguntas Frecuentes -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
    <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border-b border-yellow-200">
        <div class="flex items-center">
            <i class="fas fa-question-circle text-yellow-600 text-xl mr-3"></i>
            <h3 class="text-xl font-bold text-gray-800">Preguntas Frecuentes</h3>
        </div>
    </div>
    
    <div class="divide-y divide-gray-200" x-data="{ open: null }">
        <!-- FAQ 1 -->
        <div class="p-4 hover:bg-gray-50 cursor-pointer" @click="open = open === 1 ? null : 1">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold mr-3">1</span>
                    <h4 class="font-medium text-gray-800">¿Cómo creo un nuevo ticket de soporte?</h4>
                </div>
                <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{'rotate-180': open === 1}"></i>
            </div>
            <div x-show="open === 1" x-collapse class="mt-3 pl-11 text-gray-600 text-sm">
                <p>Para crear un nuevo ticket de soporte, haz clic en el botón "Crear Ticket" en la parte superior. Completa el formulario con el título, descripción, prioridad y tipo de solicitud. También puedes adjuntar archivos si es necesario.</p>
                <div class="mt-2 bg-blue-50 rounded-lg p-3 border border-blue-200">
                    <i class="fas fa-lightbulb text-blue-500 mr-2"></i>
                    <span class="text-blue-700 text-sm">Consejo: Sé lo más detallado posible en la descripción para que el equipo de soporte pueda ayudarte mejor.</span>
                </div>
            </div>
        </div>
        
        <!-- FAQ 2 -->
        <div class="p-4 hover:bg-gray-50 cursor-pointer" @click="open = open === 2 ? null : 2">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold mr-3">2</span>
                    <h4 class="font-medium text-gray-800">¿Cómo puedo dar seguimiento a mi ticket?</h4>
                </div>
                <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{'rotate-180': open === 2}"></i>
            </div>
            <div x-show="open === 2" x-collapse class="mt-3 pl-11 text-gray-600 text-sm">
                <p>Puedes dar seguimiento a tus tickets desde la sección "Mis Tickets". Allí verás el estado actual de cada solicitud:</p>
                <ul class="list-disc ml-5 mt-2 space-y-1">
                    <li><span class="text-yellow-600">●</span> <strong>Pendiente:</strong> Esperando revisión del equipo de soporte</li>
                    <li><span class="text-blue-600">●</span> <strong>En revisión:</strong> Un agente está analizando tu solicitud</li>
                    <li><span class="text-purple-600">●</span> <strong>En desarrollo:</strong> Se está trabajando en la solución</li>
                    <li><span class="text-green-600">●</span> <strong>Resuelto:</strong> Tu ticket ha sido completado</li>
                </ul>
            </div>
        </div>
        
        <!-- FAQ 3 -->
        <div class="p-4 hover:bg-gray-50 cursor-pointer" @click="open = open === 3 ? null : 3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold mr-3">3</span>
                    <h4 class="font-medium text-gray-800">¿Qué tipos de solicitudes puedo crear?</h4>
                </div>
                <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{'rotate-180': open === 3}"></i>
            </div>
            <div x-show="open === 3" x-collapse class="mt-3 pl-11 text-gray-600 text-sm">
                <p>Puedes crear tres tipos de solicitudes:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                    <div class="bg-red-50 rounded-lg p-3 border border-red-200">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-bug text-red-500 mr-2"></i>
                            <span class="font-medium text-red-700">Error</span>
                        </div>
                        <p class="text-xs text-red-600">Reporta un error o bug en el sistema</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-lightbulb text-blue-500 mr-2"></i>
                            <span class="font-medium text-blue-700">Solicitud</span>
                        </div>
                        <p class="text-xs text-blue-600">Solicita una nueva funcionalidad o mejora</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-rocket text-green-500 mr-2"></i>
                            <span class="font-medium text-green-700">Mejora</span>
                        </div>
                        <p class="text-xs text-green-600">Propón mejoras para el sistema existente</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FAQ 4 -->
        <div class="p-4 hover:bg-gray-50 cursor-pointer" @click="open = open === 4 ? null : 4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold mr-3">4</span>
                    <h4 class="font-medium text-gray-800">¿Cómo sé cuándo mi ticket ha sido resuelto?</h4>
                </div>
                <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{'rotate-180': open === 4}"></i>
            </div>
            <div x-show="open === 4" x-collapse class="mt-3 pl-11 text-gray-600 text-sm">
                <p>Recibirás una notificación en el sistema cuando tu ticket cambie de estado. También recibirás un correo electrónico con la actualización.</p>
                <div class="mt-2 bg-green-50 rounded-lg p-3 border border-green-200">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-700 text-sm">Los tickets resueltos aparecerán con el estado "Completado" en tu lista de tickets.</span>
                </div>
            </div>
        </div>
        
        <!-- FAQ 5 -->
        <div class="p-4 hover:bg-gray-50 cursor-pointer" @click="open = open === 5 ? null : 5">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold mr-3">5</span>
                    <h4 class="font-medium text-gray-800">¿Puedo adjuntar archivos a mi ticket?</h4>
                </div>
                <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{'rotate-180': open === 5}"></i>
            </div>
            <div x-show="open === 5" x-collapse class="mt-3 pl-11 text-gray-600 text-sm">
                <p>Sí, puedes adjuntar archivos a tu ticket para ayudar a explicar mejor tu solicitud.</p>
                <ul class="list-disc ml-5 mt-2 space-y-1 text-sm">
                    <li>Capturas de pantalla (JPG, PNG)</li>
                    <li>Archivos de log (TXT, LOG)</li>
                    <li>Documentos (PDF, DOCX)</li>
                    <li>Videos cortos (MP4, AVI) - Máximo 10MB</li>
                </ul>
                <div class="mt-2 bg-yellow-50 rounded-lg p-3 border border-yellow-200">
                    <i class="fas fa-info-circle text-yellow-500 mr-2"></i>
                    <span class="text-yellow-700 text-sm">Máximo 10MB por archivo y 5 archivos por ticket.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tutorial rápido -->
<div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-8 text-white">
    <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-video text-3xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold">¿Necesitas ayuda visual?</h3>
                <p class="text-yellow-100 text-sm">Mira nuestro tutorial rápido sobre cómo usar el sistema de tickets</p>
            </div>
        </div>
        <button class="mt-4 md:mt-0 px-6 py-3 bg-white text-yellow-600 rounded-lg hover:bg-yellow-50 transition font-medium flex items-center">
            <i class="fas fa-play-circle mr-2"></i> Ver Tutorial
        </button>
    </div>
</div>

<!-- Contacto -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition">
        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-envelope text-blue-600 text-xl"></i>
        </div>
        <h4 class="font-semibold text-gray-800">Correo</h4>
        <p class="text-sm text-gray-500">soporte@erp.com</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition">
        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-phone text-green-600 text-xl"></i>
        </div>
        <h4 class="font-semibold text-gray-800">Teléfono</h4>
        <p class="text-sm text-gray-500">(81) 1234-5678</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition">
        <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-clock text-yellow-600 text-xl"></i>
        </div>
        <h4 class="font-semibold text-gray-800">Horario</h4>
        <p class="text-sm text-gray-500">Lun-Vie 8:00 - 18:00</p>
    </div>
</div>
@endsection