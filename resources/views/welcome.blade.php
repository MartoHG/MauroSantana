<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mauro Santana - Concejal | Puerto San Julián</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        
        /* COLORES PERSONALIZADOS */
        .bg-mauro-blue { background-color: #3CA9E2; }
        .text-mauro-blue { color: #3CA9E2; }
        .bg-mauro-yellow { background-color: #FBBF24; }
        .text-mauro-yellow { color: #FBBF24; }
        .bg-mauro-dark { background-color: #111827; }

        /* Animación de desplazamiento infinito */
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); } 
}

.animate-scroll {
    display: flex;
    width: max-content; 
    animation: scroll 40s linear infinite; 
}

.animate-scroll:hover {
    animation-play-state: paused;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
    </style>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Mauro Santana" class="h-16 w-auto hover:scale-105 transition transform">
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-600 hover:text-mauro-blue font-bold text-sm uppercase tracking-wider transition">Inicio</a>
                    <a href="#proyectos" class="text-gray-600 hover:text-mauro-blue font-bold text-sm uppercase tracking-wider transition">Proyectos</a>
                    <a href="#contacto" class="text-gray-600 hover:text-mauro-blue font-bold text-sm uppercase tracking-wider transition">Contacto</a>
                    
                    {{-- SOLO MOSTRAMOS BOTÓN SI YA ESTÁS LOGUEADO (ADMIN) --}}
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-mauro-blue text-white rounded-full font-bold hover:bg-blue-500 transition shadow-md">
                                Ir al Dashboard
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <header class="relative bg-gradient-to-r from-gray-900 to-gray-800 pt-32 pb-16 md:pt-48 md:pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-mauro-blue transform -skew-y-6 origin-top-left scale-150"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between">
                
                <div class="w-full md:w-1/2 text-center md:text-left mb-12 md:mb-0">
                    <div class="inline-block bg-mauro-yellow text-gray-900 py-1 px-4 rounded-full text-xs font-black uppercase tracking-widest mb-6 shadow-lg">
                        CONCEJAL
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-6">
                        TRABAJANDO POR <br>
                        <span class="text-mauro-blue">PUERTO SAN JULIÁN</span>
                    </h1>
                    <p class="text-lg text-gray-300 mb-8 font-light max-w-lg mx-auto md:mx-0">
                        Un compromiso real con cada vecino. Accedé a mis proyectos, ordenanzas y labor legislativa de forma transparente.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="#proyectos" class="px-8 py-4 bg-mauro-blue text-white font-bold rounded-lg shadow-lg hover:bg-blue-500 transition transform hover:-translate-y-1">
                            Ver Proyectos
                        </a>
                        <a href="#contacto" class="px-8 py-4 bg-transparent border border-gray-500 text-white font-bold rounded-lg hover:bg-white hover:text-gray-900 transition">
                            Escribime
                        </a>
                    </div>
                </div>

                <div class="w-full md:w-1/2 flex justify-center md:justify-end relative">
                    <div class="absolute top-10 right-10 w-64 h-64 bg-mauro-yellow rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
                    
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 transform rotate-2 hover:rotate-0 transition duration-500">
                        <img src="{{ asset('images/mauro_hero.jpg') }}" alt="Mauro Santana Trabajando" class="w-full max-w-md object-cover">
                        
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-6 pt-20">
                            <p class="text-white font-bold text-lg">Mauro Santana</p>
                            <p class="text-mauro-yellow text-sm">Todos Somos Pueblo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 30L60 35C120 40 240 50 360 55C480 60 600 60 720 50C840 40 960 20 1080 15C1200 10 1320 20 1380 25L1440 30V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V30Z" fill="#F9FAFB"/>
            </svg>
        </div>
    </header>

<section id="proyectos" class="py-20 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
<div class="text-center mb-10">
    <span class="text-mauro-blue font-bold tracking-widest uppercase text-sm">Transparencia</span>
    <h2 class="text-4xl font-black text-gray-900 mt-2">Labor Legislativa</h2>
    <div class="w-20 h-1.5 bg-mauro-yellow mx-auto mt-4 rounded-full mb-6"></div>

    {{-- NUEVO BOTÓN VER TODO --}}
    <a href="{{ route('projects.public') }}" class="inline-flex items-center px-6 py-2 border-2 border-mauro-blue text-mauro-blue font-bold rounded-full hover:bg-mauro-blue hover:text-white transition duration-300 group">
        Ver Todo el Historial
        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
    </a>
</div>
        </div>

        @if($projects->count() > 0)
            
            {{-- LÓGICA: ¿ANIMAR O NO ANIMAR? --}}
            @if($projects->count() > 4)
            
                <div class="relative w-full">
                    <div class="absolute top-0 left-0 h-full w-16 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
                    <div class="absolute top-0 right-0 h-full w-16 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>

                    <div class="animate-scroll gap-8 pl-4">
                        {{-- Primera vuelta --}}
                        @foreach($projects as $project)
                            @include('partials.project-card', ['project' => $project])
                        @endforeach
                        {{-- Segunda vuelta (Duplicado para el infinito) --}}
                        @foreach($projects as $project)
                            @include('partials.project-card', ['project' => $project])
                        @endforeach
                    </div>
                </div>

            @else

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-wrap justify-center gap-8">
                        @foreach($projects as $project)
                            @include('partials.project-card', ['project' => $project])
                        @endforeach
                    </div>
                </div>

            @endif

        @else
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 text-lg">Aún no se han cargado proyectos públicos.</p>
                </div>
            </div>
        @endif
    </section>

    <footer id="contacto" class="bg-gray-900 text-white pt-16 pb-8 border-t-4 border-mauro-yellow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div class="text-center md:text-left">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Footer" class="h-16 w-auto mx-auto md:mx-0 mb-6 bg-white rounded-full p-1">
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Concejal de Puerto San Julián.<br>
                        Compromiso, trabajo y gestión para nuestra ciudad.
                    </p>
                </div>
                <div class="text-center">
                    <h4 class="text-lg font-bold text-white mb-6 uppercase tracking-wider">Enlaces Rápidos</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-mauro-yellow transition">Inicio</a></li>
                        <li><a href="#proyectos" class="hover:text-mauro-yellow transition">Proyectos y Ordenanzas</a></li>
                        {{-- Eliminado el enlace de Login de aquí --}}
                    </ul>
                </div>
                <div class="text-center md:text-right">
                    <h4 class="text-lg font-bold text-white mb-6 uppercase tracking-wider">Contacto</h4>
                    <p class="text-gray-400 mb-2">Puerto San Julián, Santa Cruz</p>
                    <a href="mailto:contacto@maurosantana.com" class="text-mauro-blue font-bold text-lg hover:text-white transition">contacto@maurosantana.com</a>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-xs text-gray-600">
                &copy; {{ date('Y') }} Mauro Santana. Todos los derechos reservados.
            </div>
        </div>
    </footer>
</body>
</html>