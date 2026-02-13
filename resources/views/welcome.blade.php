<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden" style="background-color: #083CAE !important;">
        <!-- Contenedor principal -->
        <div class="w-full max-w-6xl mx-4 bg-white backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-gray-200/50 transform transition-all duration-500 hover:shadow-3xl z-10">
            <div class="flex flex-col md:flex-row">
                <!-- Panel izquierdo - Banner -->
                <div class="w-full md:w-1/2 bg-gradient-to-br from-blue-900 to-blue-900 relative overflow-hidden">
                    <!-- Imagen de construcción -->
                    <div class="absolute inset-0 opacity-90">
                        <img 
                            src="../img/login/banner-costruccion.jpg" 
                            alt="Proyecto de Construcción" 
                            class="w-full h-full object-cover transform transition-transform duration-700 hover:scale-105"
                            onerror="this.src='https://images.unsplash.com/photo-1541888946425-d81bb19240f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'"
                        />
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900/70 via-transparent to-transparent"></div>
                    </div>

                    <!-- Logo en el banner (versión móvil) -->
                    <div class="relative z-20 p-6 md:hidden">
                        <img 
                            src="../img/login/logophoto.png" 
                            alt="Logo Empresa" 
                            class="h-16 mx-auto object-contain"
                            onerror="this.src='https://via.placeholder.com/200x60?text=LOGO+CONSTRUCCIÓN'"
                        />
                    </div>

                    <!-- Elementos decorativos flotantes -->
                    <div class="absolute top-4 right-4 w-12 h-12 md:w-16 md:h-16 bg-amber-500/10 rounded-full animate-bounce-slow"></div>
                    <div class="absolute bottom-4 left-4 w-10 h-10 md:w-12 md:h-12 bg-blue-500/10 rounded-full animate-bounce-slow delay-300"></div>
                </div>

                <!-- Panel derecho - Formulario -->
                <div class="w-full md:w-1/2 p-6 md:p-8 lg:p-12">
                    <!-- Logo principal centrado (solo desktop) -->
                    <div class="mb-4 md:mb-6 hidden md:flex items-center justify-center">
                        <img 
                            src="../img/login/logophoto.png" 
                            alt="Logo Empresa" 
                            class="h-20 object-contain"
                            style="max-width: 180px;"
                            onerror="this.src='https://via.placeholder.com/180x60?text=LOGO'"
                        />
                    </div>

                    <p class="text-blue-900 text-center text-sm md:text-base mb-6 md:mb-8">
                        Lider en Rentabilidad de Costrucccion
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                        @csrf

                        <!-- Email -->
                        <div class="group">
                            <x-input-label for="email" value="Correo Electrónico" class="text-gray-700 font-medium" />
                            <div class="relative mt-1 md:mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <x-text-input
                                    id="email"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    autofocus
                                    class="mt-1 block w-full pl-10 md:pl-10 rounded-lg md:rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm md:text-base"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1 md:mt-2 text-xs md:text-sm" />
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <x-input-label for="password" value="Contraseña" class="text-gray-700 font-medium" />
                            <div class="relative mt-1 md:mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="mt-1 block w-full pl-10 md:pl-10 rounded-lg md:rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm md:text-base"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1 md:mt-2 text-xs md:text-sm" />
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center text-xs md:text-sm text-gray-600 group cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition h-4 w-4">
                                <span class="ml-2 group-hover:text-blue-700 transition-colors">Recordar sesión</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-xs md:text-sm text-blue-600 hover:text-blue-800 hover:underline transition-all" href="{{ route('password.request') }}">
                                    ¿Contraseña olvidada?
                                </a>
                            @endif
                        </div>

                        <!-- Button -->
                        <button
                            type="submit"
                            class="w-full py-2.5 md:py-3 rounded-lg md:rounded-xl bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold hover:from-blue-700 hover:to-blue-900 transform hover:-translate-y-0.5 transition-all duration-300 shadow-lg hover:shadow-xl active:transform active:translate-y-0 text-sm md:text-base"
                        >
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Iniciar Sesión
                            </span>
                        </button>
                    </form>

                    <!-- Footer adicional -->
                    <div class="mt-6 md:mt-8 pt-4 md:pt-6 border-t border-gray-200 text-center">
                        <p class="text-xs md:text-sm text-gray-500">
                            © 2026 MejoraSoft. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Agregar estilos adicionales para forzar el color de fondo -->
    <style>
        /* Forzar el color de fondo en el contenedor principal */
        .min-h-screen.flex.items-center.justify-center.relative.overflow-hidden {
            background-color: #083CAE !important;
        }
        
        /* También forzar en el body si es necesario */
        body {
            background-color: #083CAE !important;
        }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
        
        .animate-bounce-slow {
            animation: bounce-slow 3s infinite ease-in-out;
        }
        
        /* Animación de entrada para el formulario */
        .group input:focus {
            transform: scale(1.02);
            box-shadow: 0 8px 20px -5px rgba(59, 130, 246, 0.3);
        }
        
        /* Estilo específico para el logo - Reducido */
        img[alt="Logo Empresa"] {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            max-width: 180px !important;
            width: auto;
        }
        
        /* Estilo para el contenedor del logo */
        .hidden.md\\:flex.items-center.justify-center {
            margin-top: 0 !important;
            margin-bottom: 0.5rem !important;
        }
        
        /* Reducir espacio alrededor del logo */
        .p-6.md\\:p-8.lg\\:p-12 {
            padding-top: 1.5rem !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .relative.z-10 {
                padding: 1rem;
            }
        }
    </style>
</x-guest-layout>