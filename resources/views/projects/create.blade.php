<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Documento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tipo de Documento</label>
                        <select name="tipo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                            <option value="Proyecto">Proyecto</option>
                            <option value="Ordenanza">Ordenanza</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Título</label>
                        <input type="text" name="titulo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Categoría</label>
                        <select name="categoria" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                            <option value="Salud">Salud</option>
                            <option value="Obras Públicas">Obras Públicas</option>
                            <option value="Educación">Educación</option>
                            <option value="Social">Social</option>
                            <option value="Deporte">Deporte</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Fecha de Presentación</label>
                        <input type="date" name="fecha" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Descripción (Opcional)</label>
                        <textarea name="descripcion" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1"></textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Archivo PDF</label>
                        <input type="file" name="pdf" accept=".pdf" class="border border-gray-300 rounded-md w-full p-2 mt-1" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Imagen de Portada (Opcional)</label>
                        <input type="file" name="imagen" accept="image/*" class="border border-gray-300 rounded-md w-full p-2 mt-1">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('projects.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                            Cancelar
                        </a>
                        
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Guardar Proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>