<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Documento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tipo de Documento</label>
                        <select name="tipo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                            <option value="Proyecto" {{ $project->tipo == 'Proyecto' ? 'selected' : '' }}>Proyecto</option>
                            <option value="Ordenanza" {{ $project->tipo == 'Ordenanza' ? 'selected' : '' }}>Ordenanza</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Título</label>
                        <input type="text" name="titulo" value="{{ $project->titulo }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Categoría</label>
                        <select name="categoria" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                            @foreach(['Salud', 'Obras Públicas', 'Educación', 'Social', 'Deporte', 'Otros'] as $cat)
                                <option value="{{ $cat }}" {{ $project->categoria == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Fecha de Presentación</label>
                        <input type="date" name="fecha" value="{{ $project->fecha }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Descripción (Opcional)</label>
                        <textarea name="descripcion" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">{{ $project->descripcion }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Archivo PDF Actual (Subir solo para cambiar)</label>
                        <div class="flex items-center gap-4">
                            <a href="{{ asset('storage/'.$project->pdf_path) }}" target="_blank" class="text-blue-600 underline text-sm">Ver actual</a>
                            <input type="file" name="pdf" accept=".pdf" class="border border-gray-300 rounded-md w-full p-2">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Imagen de Portada Actual (Subir solo para cambiar)</label>
                        @if($project->imagen_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$project->imagen_path) }}" class="h-20 w-auto rounded border">
                            </div>
                        @endif
                        <input type="file" name="imagen" accept="image/*" class="border border-gray-300 rounded-md w-full p-2">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('projects.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancelar</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Actualizar Proyecto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>