<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-mauro-dark leading-tight">
                {{ __('Proyectos y ordenanzas') }}
            </h2>
            @can('create', \App\Models\Project::class)
                <a href="{{ route('projects.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-mauro-blue px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue-dark focus-visible:ring-offset-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Cargar documento
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">{{ session('success') }}</div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Título</th>
                            <th class="px-6 py-3 text-left font-semibold">Tipo</th>
                            <th class="px-6 py-3 text-left font-semibold">Categoría</th>
                            <th class="px-6 py-3 text-left font-semibold">Fecha</th>
                            <th class="px-6 py-3 text-center font-semibold">Archivo</th>
                            <th class="px-6 py-3 text-center font-semibold">QR</th>
                            <th class="px-6 py-3 text-right font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($projects as $project)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-6 py-3 font-medium text-mauro-dark max-w-xs truncate">{{ $project->titulo }}</td>
                                <td class="px-6 py-3"><x-tipo-badge :tipo="$project->tipo" /></td>
                                <td class="px-6 py-3 text-gray-600">{{ $project->categoria }}</td>
                                <td class="px-6 py-3 text-gray-600 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($project->fecha)->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-center">
                                    <a href="{{ asset('storage/' . $project->pdf_path) }}" target="_blank" rel="noopener"
                                       class="font-semibold text-mauro-blue-dark hover:underline">Ver PDF</a>
                                </td>
                                <td class="px-6 py-3">
                                    @if($project->qr_path)
                                        <div class="flex flex-col items-center gap-1">
                                            <img src="{{ asset('storage/' . $project->qr_path) }}" alt="Código QR de {{ $project->titulo }}" class="w-12 h-12">
                                            <a href="{{ asset('storage/' . $project->qr_path) }}" download="QR_{{ $project->titulo }}.svg"
                                               class="text-xs font-semibold text-mauro-blue-dark hover:underline">Descargar</a>
                                        </div>
                                    @else
                                        <span class="block text-center text-xs text-gray-400">Sin QR</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        @can('update', $project)
                                            <a href="{{ route('projects.edit', $project) }}" class="font-semibold text-mauro-blue-dark hover:underline">Editar</a>
                                        @endcan
                                        @can('delete', $project)
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                                  onsubmit="return confirm('¿Eliminar «{{ $project->titulo }}»?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-red-600 hover:underline">Eliminar</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    Todavía no hay documentos cargados.
                                    @can('create', \App\Models\Project::class)
                                        <a href="{{ route('projects.create') }}" class="ml-1 font-semibold text-mauro-blue-dark hover:underline">Cargar el primero &rarr;</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
