<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Nuevo Proyecto Legislativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- 1. TIPO (Proyecto u Ordenanza) --}}
    <div class="mb-4">
        <label for="tipo" class="block text-gray-700 text-sm font-bold mb-2">Tipo de Documento:</label>
        <select name="tipo" id="tipo" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="Proyecto">Proyecto</option>
            <option value="Ordenanza">Ordenanza</option>
        </select>
        @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    {{-- 2. TÍTULO --}}
    <div class="mb-4">
        <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
        <input type="text" name="titulo" id="titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        @error('titulo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    {{-- 3. CATEGORÍA --}}
    <div class="mb-4">
        <label for="categoria" class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
        <select name="categoria" id="categoria" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="Salud">Salud</option>
            <option value="Obras Públicas">Obras Públicas</option>
            <option value="Educación">Educación</option>
            <option value="Social">Social</option>
            <option value="Otros">Otros</option>
        </select>
        @error('categoria') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    {{-- 4. FECHA --}}
    <div class="mb-4">
        <label for="fecha" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Presentación:</label>
        <input type="date" name="fecha" id="fecha" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        @error('fecha') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    {{-- 5. ARCHIVO PDF (Obligatorio) --}}
    <div class="mb-4">
        <label for="pdf" class="block text-gray-700 text-sm font-bold mb-2">Archivo PDF del Proyecto:</label>
        <input type="file" name="pdf" id="pdf" accept=".pdf" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        <p class="text-gray-500 text-xs italic mt-1">Este es el archivo que se descargará al escanear el QR.</p>
        @error('pdf') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    {{-- 6. IMAGEN DE PORTADA (Opcional) --}}
    <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
        <label for="imagen" class="block text-blue-800 text-sm font-bold mb-2">
            Imagen de Portada (Opcional):
        </label>
        <input type="file" name="imagen" id="imagen" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <p class="text-gray-500 text-xs italic mt-1">Sube una foto representativa para que se vea bonita en la web. Si no subes nada, se pondrá una imagen por defecto.</p>
        @error('imagen') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    {{-- BOTONES --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('projects.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Cancelar
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Guardar Proyecto
        </button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>