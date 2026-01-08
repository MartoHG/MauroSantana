<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscador - Mauro Santana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .bg-mauro-blue { background-color: #3CA9E2; }
        .text-mauro-blue { color: #3CA9E2; }
        .bg-mauro-yellow { background-color: #FBBF24; }
    </style>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto mr-2">
                    <span class="font-bold text-gray-800 hidden sm:block">VOLVER AL INICIO</span>
                </a>
            </div>
        </div>
    </nav>

    <header class="bg-mauro-blue pt-32 pb-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-black text-white mb-4">BUSCADOR LEGISLATIVO</h1>
            <p class="text-blue-100 text-lg">Encuentra proyectos, ordenanzas y resoluciones.</p>
        </div>
    </header>

    <section class="py-8 -mt-8 px-4">
        <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <form action="{{ route('projects.public') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <div class="col-span-1 md:col-span-4 lg:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Buscar por nombre</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ej: Pavimentación..." class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-mauro-blue pl-10">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tipo</label>
                    <select name="tipo" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-mauro-blue bg-white">
                        <option value="">Todos</option>
                        <option value="Proyecto" {{ request('tipo') == 'Proyecto' ? 'selected' : '' }}>Proyectos</option>
                        <option value="Ordenanza" {{ request('tipo') == 'Ordenanza' ? 'selected' : '' }}>Ordenanzas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Categoría</label>
                    <select name="categoria" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-mauro-blue bg-white">
                        <option value="">Todas</option>
                        <option value="Salud" {{ request('categoria') == 'Salud' ? 'selected' : '' }}>Salud</option>
                        <option value="Obras Públicas" {{ request('categoria') == 'Obras Públicas' ? 'selected' : '' }}>Obras Públicas</option>
                        <option value="Educación" {{ request('categoria') == 'Educación' ? 'selected' : '' }}>Educación</option>
                        <option value="Social" {{ request('categoria') == 'Social' ? 'selected' : '' }}>Social</option>
                        <option value="Otros" {{ request('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ordenar por</label>
                        <select name="orden" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-mauro-blue bg-white">
                            <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Más nuevos</option>
                            <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Más viejos</option>
                            <option value="alpha_asc" {{ request('orden') == 'alpha_asc' ? 'selected' : '' }}>A - Z</option>
                            <option value="cat_asc" {{ request('orden') == 'cat_asc' ? 'selected' : '' }}>Categoría</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-mauro-blue hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow transition h-10 w-full">
                            Filtrar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($projects->count() > 0)
                <div class="flex flex-wrap justify-center gap-8">
                    @foreach($projects as $project)
                        {{-- Reutilizamos tu tarjeta existente --}}
                        @include('partials.project-card', ['project' => $project])
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-xl font-bold text-gray-600">No se encontraron resultados</h3>
                    <p class="text-gray-400">Intenta cambiar los filtros de búsqueda.</p>
                    <a href="{{ route('projects.public') }}" class="text-mauro-blue font-bold mt-2 inline-block">Limpiar filtros</a>
                </div>
            @endif

        </div>
    </section>

</body>
</html>