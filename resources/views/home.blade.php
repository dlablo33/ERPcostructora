@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Header Simple -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900">
                        <span class="text-blue-700">ConstructoraPro</span>
                    </h1>
                    <p class="text-gray-600 mt-2">Mejorasoft Costruccion ERP</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Bienvenido</p>
                        <p class="font-semibold text-gray-900">{{ Auth::user()->name ?? 'Usuario' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 border-2 border-blue-300 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Usuario') }}&background=3b82f6&color=fff" 
                             alt="Usuario" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna Izquierda: Presentación -->
            <div class="lg:col-span-2">
                <!-- Banner Empresa -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl overflow-hidden shadow-xl mb-8">
                    <div class="p-8 text-white">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 rounded-lg bg-white/20 flex items-center justify-center mr-4">
                                <i class="fas fa-building text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Bienvenido <span class="font-semibold">ConstructoraPro</span></h2>
                            </div>
                        
                        </div>
                    </div>
                </div>

                <!-- Instructivo Rápido -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-book-open text-blue-600 mr-3"></i>
                        Instructivo Rápido del Sistema
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-blue-700 font-bold">1</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Acceso a Módulos</h4>
                                <p class="text-gray-600">Utilice el menú lateral o los accesos directos para navegar entre los diferentes módulos del sistema.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-green-700 font-bold">2</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Dashboard Principal</h4>
                                <p class="text-gray-600">Consulte métricas clave y resúmenes ejecutivos en el dashboard de inicio.</p>
                                <button onclick="showMessage('Ir al Dashboard')" class="mt-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-external-link-alt mr-1"></i> Ir al Dashboard
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-purple-700 font-bold">3</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Gestión de Tareas</h4>
                                <p class="text-gray-600">Organice y priorice sus actividades diarias en el módulo de tareas.</p>
                                <button onclick="showMessage('Ir a Tareas')" class="mt-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm hover:bg-purple-200 transition-colors">
                                    <i class="fas fa-external-link-alt mr-1"></i> Ir a Tareas
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-orange-700 font-bold">4</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2">Soporte Técnico</h4>
                                <p class="text-gray-600">Para asistencia, utilice el botón de soporte en la parte inferior de la pantalla.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Tutorial -->
                <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                            <i class="fas fa-video mr-3 text-blue-400"></i>
                            Próximamente: Video Tutorial
                        </h3>
                        <div class="bg-gray-800 rounded-lg p-4 flex items-center justify-center h-48">
                            <div class="text-center">
                                <i class="fas fa-clock text-4xl text-blue-400 mb-4"></i>
                                <p class="text-gray-300">Video tutorial en desarrollo</p>
                                <p class="text-sm text-gray-400 mt-2">Disponible en la próxima actualización</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Accesos Directos y Soporte -->
            <div class="space-y-8">
                <!-- Accesos a Módulos - NO sticky -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-rocket text-blue-600 mr-3"></i>
                        Accesos Directos
                    </h3>
                    
                    <div class="space-y-4">
                        <button onclick="showMessage('Ir al Dashboard')" class="w-full flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-200 group text-left hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center mr-4">
                                <i class="fas fa-tachometer-alt text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-blue-700">Dashboard</h4>
                                <p class="text-sm text-gray-600">Vista general del sistema</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition-transform group-hover:translate-x-1"></i>
                        </button>
                        
                        <button onclick="showMessage('Ir a Tareas')" class="w-full flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all duration-200 group text-left hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-green-600 flex items-center justify-center mr-4">
                                <i class="fas fa-tasks text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Tareas</h4>
                                <p class="text-sm text-gray-600">Gestión de actividades</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 transition-transform group-hover:translate-x-1"></i>
                        </button>
                        
                        <button onclick="showMessage('Ir a Proyectos')" class="w-full flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition-all duration-200 group text-left hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-purple-600 flex items-center justify-center mr-4">
                                <i class="fas fa-project-diagram text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-purple-700">Proyectos</h4>
                                <p class="text-sm text-gray-600">Control de obras</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600 transition-transform group-hover:translate-x-1"></i>
                        </button>
                        
                        <button onclick="showMessage('Ir a Finanzas')" class="w-full flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition-all duration-200 group text-left hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-orange-600 flex items-center justify-center mr-4">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-orange-700">Finanzas</h4>
                                <p class="text-sm text-gray-600">Gestión económica</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-orange-600 transition-transform group-hover:translate-x-1"></i>
                        </button>
                        
                        <button onclick="showMessage('Ir a Recursos Humanos')" class="w-full flex items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group text-left hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-red-600 flex items-center justify-center mr-4">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-red-700">Recursos Humanos</h4>
                                <p class="text-sm text-gray-600">Gestión de personal</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-600 transition-transform group-hover:translate-x-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Soporte Técnico - AHORA visible -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-white mb-4">¿Necesita Ayuda?</h3>
                    <p class="text-blue-100 mb-6">Contacte a nuestro equipo de soporte</p>
                    
                    <div class="space-y-4">
                        <button onclick="showMessage('Abrir chat de soporte')" class="w-full flex items-center p-3 bg-white/20 hover:bg-white/30 rounded-lg transition-colors group text-left">
                            <div class="w-10 h-10 rounded-full bg-white/30 flex items-center justify-center mr-3">
                                <i class="fas fa-headset text-white"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">Chat en Vivo</p>
                                <p class="text-blue-200 text-sm">Soporte inmediato</p>
                            </div>
                        </button>
                        
                        <button onclick="showMessage('Enviar correo a soporte')" class="w-full flex items-center p-3 bg-white/20 hover:bg-white/30 rounded-lg transition-colors group text-left">
                            <div class="w-10 h-10 rounded-full bg-white/30 flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">Correo Electrónico</p>
                                <p class="text-blue-200 text-sm">soporte@constructorapro.com</p>
                            </div>
                        </button>
                        
                        <button onclick="showMessage('Llamar a soporte')" class="w-full flex items-center p-3 bg-white/20 hover:bg-white/30 rounded-lg transition-colors group text-left">
                            <div class="w-10 h-10 rounded-full bg-white/30 flex items-center justify-center mr-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">Teléfono</p>
                                <p class="text-blue-200 text-sm">+1 (800) 123-4567</p>
                            </div>
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Novedades del Sistema -->
        <div class="mt-12 bg-white rounded-2xl shadow-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-bullhorn text-blue-600 mr-3"></i>
                    Novedades del Sistema
                </h3>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    V.1.0
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 transition-colors hover:shadow-md">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Implementado</h4>
                    </div>
                    <p class="text-gray-600">Dashboard ejecutivo con métricas clave del negocio.</p>
                </div>
                
                <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 transition-colors hover:shadow-md">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                            <i class="fas fa-check text-blue-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Disponible</h4>
                    </div>
                    <p class="text-gray-600">Sistema de gestión de tareas y productividad.</p>
                </div>
                
                <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 transition-colors hover:shadow-md">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                            <i class="fas fa-hourglass-half text-purple-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">En Desarrollo</h4>
                    </div>
                    <p class="text-gray-600">Módulo de proyectos y control de obras.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Simple -->
    <div class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center mr-3">
                            <i class="fas fa-hard-hat"></i>
                        </div>
                        <div>
                            <div class="font-bold">ConstructoraPro ERP</div>
                            <div class="text-sm text-gray-400">© {{ date('Y') }} - Sistema en Desarrollo</div>
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-400">Software contratado por: <span class="font-semibold text-white">Constructora Excelencia S.A.</span></p>
                    <p class="text-sm text-gray-500 mt-1">Versión 1.0 - Fase de Implementación</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Funciones simples de interacción
function showMessage(action) {
    alert(`Acción: ${action}\n\nEsta función estará disponible cuando las rutas estén configuradas.\n\nPor ahora, puede usar el menú lateral para navegar.`);
}

// Efecto hover en tarjetas
document.addEventListener('DOMContentLoaded', function() {
    // Efecto hover para botones de accesos
    const accessButtons = document.querySelectorAll('.transition-all');
    accessButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Mostrar mensaje de bienvenida en consola
    console.log('ConstructoraPro ERP - Pantalla inicial cargada');
    console.log('Usuario: ' + (document.querySelector('.font-semibold.text-gray-900')?.textContent || 'No identificado'));
    console.log('Soporte técnico ahora visible correctamente');
});
</script>

<style>
/* Estilos para mejorar la visibilidad */
.transition-all {
    transition: all 0.2s ease;
}

/* Espaciado mejorado */
.space-y-8 > * + * {
    margin-top: 2rem;
}

/* Responsive mejorado */
@media (max-width: 768px) {
    .text-3xl {
        font-size: 1.875rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
    
    .space-y-8 > * + * {
        margin-top: 1.5rem;
    }
}

/* Estilo para hover en botones de soporte */
.bg-white\\/20:hover {
    background-color: rgba(255, 255, 255, 0.3);
}

/* Animación suave para flechas */
.transition-transform {
    transition: transform 0.2s ease;
}
</style>
@endsection