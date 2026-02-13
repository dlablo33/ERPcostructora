@extends('layouts.navigation')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-start pt-16 md:pt-24 >        <div class="p-8 mt-8 md:mt-12">
            <img 
                src="../img/login/logofun.png" 
                alt="Logo Empresa" 
                class="max-w-full h-auto object-contain"
                style="max-height: 70vh;"
                onerror="this.src='https://via.placeholder.com/500x500?text=LOGO'"
            />
        </div>
    </div>

    <style>
        /* Asegurar que no haya márgenes ni padding que afecten */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        
        /* Eliminar cualquier margen o padding extra del layout */
        .min-h-screen {
            margin: 0;
        }
        
        /* Transición suave al cargar */
        img {
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
@endsection