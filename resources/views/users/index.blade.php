<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- MENSAJE DE ÉXITO --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">¡Éxito!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    {{-- MENSAJE DE ERROR --}}
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">¡Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

                    {{-- BARRA DE BOTONES (Volver y Crear) --}}
                    <div class="flex justify-between items-center mb-6">
                        
                        {{-- Botón Volver al Dashboard --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center text-gray-600 hover:text-gray-900 font-bold transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver al Dashboard
                        </a>

                        {{-- Botón Crear Nuevo Usuario --}}
                        <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow hover:shadow-lg transition">
                            + Crear Nuevo Usuario
                        </a>
                    </div>

                    {{-- TABLA DE USUARIOS --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-left">Email</th>
                                    <th class="py-3 px-6 text-center">Rol</th>
                                    <th class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($users as $user)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        
                                        {{-- Nombre --}}
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="font-medium">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        
                                        {{-- Email --}}
                                        <td class="py-3 px-6 text-left">
                                            <span>{{ $user->email }}</span>
                                        </td>

                                        {{-- Rol --}}
                                        <td class="py-3 px-6 text-center">
                                            {{-- Ajusta el color según el rol --}}
                                            @php
                                                // Verifica si tu columna se llama 'role', 'rol', o 'type'
                                                $rol = $user->role ?? $user->rol ?? 'Usuario'; 
                                                $badgeColor = ($rol === 'Admin' || $rol === 'Administrador') ? 'bg-red-200 text-red-600' : 'bg-green-200 text-green-600';
                                            @endphp
                                            <span class="{{ $badgeColor }} py-1 px-3 rounded-full text-xs font-bold">
                                                {{ $rol }}
                                            </span>
                                        </td>

                                        {{-- Acciones (Editar / Eliminar) --}}
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center space-x-2">
                                                
                                                {{-- Editar --}}
                                                <a href="{{ route('users.edit', $user->id) }}" class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-full transition duration-150 ease-in-out" title="Editar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>

                                                {{-- Eliminar --}}
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');" class="inline">
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
                        
                        {{-- Mensaje si no hay usuarios --}}
                        @if($users->isEmpty())
                            <div class="text-center py-4 text-gray-500">
                                No hay usuarios registrados.
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>