<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Desarrolladores</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Logo / Icono -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-code text-white text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Área de Desarrollo</h1>
                <p class="text-gray-500 text-sm mt-1">Acceso exclusivo para desarrolladores</p>
            </div>

            <!-- Mensajes -->
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-start">
                    <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-start">
                    <i class="fas fa-check-circle mt-1 mr-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Formulario de Login -->
            <form method="POST" action="{{ route('dev.login.post') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                        Correo Electrónico
                    </label>
                    <input type="email" name="email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="tu@email.com" 
                           value="{{ old('email') }}"
                           required autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-gray-400"></i>
                        Contraseña
                    </label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="••••••••" 
                           required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-800 transition duration-200 shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Ingresar al Panel
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Acceso restringido al equipo de desarrollo
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    ¿Problemas de acceso? Contacta con soporte
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-xs text-gray-400">
            &copy; {{ date('Y') }} Sistema ERP - Área de Desarrollo
        </div>
    </div>
</body>
</html>