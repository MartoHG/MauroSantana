<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Formulario de Edición --}}
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- SECCIÓN DE CONTRASEÑA (Opcional) --}}
                        <hr class="my-6 border-gray-300"> 

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                                Nueva Contraseña (Opcional):
                            </label>
                            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="new-password">
                            <p class="text-gray-500 text-xs italic mt-1">Déjalo en blanco si no quieres cambiar la contraseña actual.</p>
                            @error('password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">
                                Confirmar Nueva Contraseña:
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <hr class="my-6 border-gray-300"> 

                        {{-- ROL (Solo Colaborador y Admin) --}}
                        <div class="mb-6">
                            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Rol:</label>
                            <select name="role" id="role" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="Colaborador" {{ $user->role == 'Colaborador' ? 'selected' : '' }}>Colaborador</option>
                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex items-center justify-between">
                            <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancelar
                            </a>
                            
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>