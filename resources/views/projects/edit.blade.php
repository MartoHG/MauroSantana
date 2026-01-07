<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Proyecto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                            <input type="text" name="titulo" value="{{ $project->titulo }}" class="border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>

                        <div class="mb-4">
                            <label for="categoria" class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                            <select name="categoria" class="border rounded w-full py-2 px-3 text-gray-700">
                                @foreach(['Salud', 'Obras Públicas', 'Educación', 'Transporte', 'Seguridad', 'Otro'] as $cat)
                                    <option value="{{ $cat }}" {{ $project->categoria == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="fecha" class="block text-gray-700 text-sm font-bold mb-2">Fecha:</label>
                            <input type="date" name="fecha" value="{{ $project->fecha }}" class="border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                            <textarea name="descripcion" rows="3" class="border rounded w-full py-2 px-3 text-gray-700">{{ $project->descripcion }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Archivo PDF Actual:</label>
                            <p class="text-sm text-gray-500 mb-2">Si no seleccionas uno nuevo, se mantendrá el actual.</p>
                            <input type="file" name="pdf_file" accept="application/pdf" class="border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('projects.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 font-bold text-sm">Cancelar</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                Actualizar Proyecto
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>