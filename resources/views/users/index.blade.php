<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-mauro-dark leading-tight">
                {{ __('Gestión de usuarios') }}
            </h2>
            <a href="{{ route('users.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-mauro-blue px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue-dark focus-visible:ring-offset-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Nuevo usuario
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ session('error') }}</div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Nombre</th>
                            <th class="px-6 py-3 text-left font-semibold">Email</th>
                            <th class="px-6 py-3 text-left font-semibold">Rol</th>
                            <th class="px-6 py-3 text-right font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-6 py-3 font-medium text-mauro-dark whitespace-nowrap">
                                    {{ $user->name }}
                                    @if(auth()->id() === $user->id)
                                        <span class="ml-1 text-xs font-normal text-gray-400">(tú)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-3">
                                    <span @class([
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border',
                                        'bg-mauro-blue-light text-mauro-blue-dark border-mauro-blue/40' => $user->isAdmin(),
                                        'bg-gray-100 text-gray-600 border-gray-200' => ! $user->isAdmin(),
                                    ])>{{ $user->role->label() }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        @can('update', $user)
                                            <a href="{{ route('users.edit', $user) }}" class="font-semibold text-mauro-blue-dark hover:underline">Editar</a>
                                        @endcan
                                        @can('delete', $user)
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                  onsubmit="return confirm('¿Eliminar a {{ $user->name }}?');" class="inline">
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
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
