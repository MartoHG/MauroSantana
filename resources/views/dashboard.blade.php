<x-app-layout>
    {{-- ================= MASTHEAD / MEMBRETE ================= --}}
    {{-- Elemento firma: banda oscura tipo membrete oficial, con filete amarillo
         y el motivo del sol del logo. Aquí gastamos la audacia; el resto queda sobrio. --}}
    <div class="relative overflow-hidden bg-mauro-dark border-b-4 border-mauro-yellow">
        {{-- Sol decorativo (eco del logo) --}}
        <div aria-hidden="true"
             class="pointer-events-none absolute -top-16 -right-16 h-64 w-64 rounded-full opacity-20"
             style="background: radial-gradient(circle, #FBBF24 0%, rgba(251,191,36,0.15) 45%, transparent 70%);"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-mauro-yellow">Panel legislativo</p>
                    <h1 class="mt-2 text-3xl font-bold text-white">Hola, {{ Auth::user()->name }}</h1>
                    <p class="mt-1 text-sm text-gray-300">
                        Concejal Mauro Santana &middot; Puerto San Julián, Santa Cruz
                    </p>
                </div>

                <div class="sm:text-right">
                    <p class="text-4xl font-bold text-white leading-none">{{ $totalDocumentos }}</p>
                    <p class="mt-1 text-sm text-gray-300">documentos publicados</p>
                    @if($ultimaCarga)
                        <p class="mt-2 text-xs text-gray-400">
                            Última carga: {{ $ultimaCarga->format('d/m/Y') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- Mensajes flash --}}
        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                {{ session('error') }}
            </div>
        @endif

        {{-- ================= KPIs ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <x-stat-card label="Proyectos" :value="$stats['proyectos']" accent="blue">
                <x-slot:icon>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card label="Ordenanzas" :value="$stats['ordenanzas']" accent="yellow">
                <x-slot:icon>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card label="Documentos totales" :value="$totalDocumentos" accent="dark">
                <x-slot:icon>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card label="Colaboradores" :value="$stats['colaboradores']" accent="slate">
                <x-slot:icon>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </x-slot:icon>
            </x-stat-card>
        </div>

        {{-- ================= ACCIONES RÁPIDAS ================= --}}
        <div>
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-3">Acciones rápidas</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('projects.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-mauro-blue px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue-dark focus-visible:ring-offset-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Cargar documento
                </a>

                <a href="{{ route('projects.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-mauro-dark shadow-sm transition hover:border-mauro-blue hover:text-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue focus-visible:ring-offset-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    Gestionar proyectos
                </a>

                @can('viewAny', \App\Models\User::class)
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-mauro-dark shadow-sm transition hover:border-mauro-blue hover:text-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue focus-visible:ring-offset-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        Gestionar usuarios
                    </a>
                @endcan

                <a href="{{ route('home') }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-mauro-dark shadow-sm transition hover:border-mauro-blue hover:text-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue focus-visible:ring-offset-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    Ver web pública
                </a>
            </div>
        </div>

        {{-- ================= ÚLTIMOS DOCUMENTOS ================= --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-bold text-mauro-dark">Últimos documentos cargados</h2>
                <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-mauro-blue-dark hover:underline">Ver todos</a>
            </div>

            @if($recientes->isEmpty())
                <div class="px-5 py-12 text-center">
                    <p class="text-sm text-gray-500">Todavía no hay documentos cargados.</p>
                    <a href="{{ route('projects.create') }}" class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-mauro-blue-dark hover:underline">
                        Cargar el primero &rarr;
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold">Título</th>
                                <th class="px-5 py-3 text-left font-semibold">Tipo</th>
                                <th class="px-5 py-3 text-left font-semibold">Categoría</th>
                                <th class="px-5 py-3 text-left font-semibold">Fecha</th>
                                <th class="px-5 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recientes as $project)
                                <tr class="hover:bg-gray-50/70">
                                    <td class="px-5 py-3 font-medium text-mauro-dark max-w-xs truncate">{{ $project->titulo }}</td>
                                    <td class="px-5 py-3">
                                        <x-tipo-badge :tipo="$project->tipo" />
                                    </td>
                                    <td class="px-5 py-3 text-gray-600">{{ $project->categoria }}</td>
                                    <td class="px-5 py-3 text-gray-600 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($project->fecha)->format('d/m/Y') }}</td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center justify-end gap-3">
                                            @can('update', $project)
                                                <a href="{{ route('projects.edit', $project) }}" class="font-semibold text-mauro-blue-dark hover:underline">Editar</a>
                                            @endcan
                                            @can('delete', $project)
                                                <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                                      onsubmit="return confirm('¿Eliminar «{{ $project->titulo }}»?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-semibold text-red-600 hover:underline">Eliminar</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
