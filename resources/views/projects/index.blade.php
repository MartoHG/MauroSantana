<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proyectos Legislativos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">¡Éxito!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('projects.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                            + Subir Nuevo Proyecto
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Título</th>
                                    <th class="py-3 px-6 text-left">Categoría</th>
                                    <th class="py-3 px-6 text-center">Fecha</th>
                                    <th class="py-3 px-6 text-center">Archivo</th>
                                    <th class="py-3 px-6 text-center">QR</th>
                                    <th class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                            </thead>
<tbody class="text-gray-600 text-sm font-light">
    @foreach ($projects as $project)
    <tr class="border-b border-gray-200 hover:bg-gray-100">
        
        <td class="py-3 px-6 text-left whitespace-nowrap">
            <div class="flex items-center">
                <span class="font-medium">{{ $project->titulo }}</span>
            </div>
        </td>
        
        <td class="py-3 px-6 text-left">
            <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                {{ $project->categoria }}
            </span>
        </td>

        <td class="py-3 px-6 text-center">
            {{ \Carbon\Carbon::parse($project->fecha)->format('d/m/Y') }}
        </td>

        <td class="py-3 px-6 text-center">
            <a href="{{ asset('storage/' . $project->pdf_path) }}" target="_blank" class="text-red-500 hover:text-red-700 font-bold underline">
                Ver PDF
            </a>
        </td>

        <td class="py-3 px-6 text-center">
            @if($project->qr_path)
                <div class="flex flex-col items-center">
                    <img src="{{ asset('storage/' . $project->qr_path) }}" alt="QR" class="w-12 h-12 mb-1">
                    <a href="{{ asset('storage/' . $project->qr_path) }}" download="QR_{{ $project->titulo }}.svg" class="text-xs text-blue-500 hover:underline">
                        Descargar
                    </a>
                </div>
            @else
                <span class="text-gray-400 text-xs">Sin QR</span>
            @endif
        </td>

        <td class="py-3 px-6 text-center">
            <div class="flex item-center justify-center space-x-2">
                
                <a href="{{ route('projects.edit', $project->id) }}" class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-full transition duration-150 ease-in-out" title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </a>

{{-- Botón ELIMINAR (Ahora visible para todos los que acceden aquí) --}}
<form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar este proyecto?');" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-full transition duration-150 ease-in-out" title="Eliminar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
</form>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                        </table>
                        
                        @if($projects->isEmpty())
                            <div class="text-center py-4 text-gray-500">
                                No hay proyectos cargados aún.
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>