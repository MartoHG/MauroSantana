<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">¡Hola, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Bienvenido al sistema de gestión legislativa.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('projects.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-blue-50 transition transform hover:-translate-y-1">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h5 class="text-xl font-bold text-gray-900">Proyectos</h5>
                    </div>
                    <p class="font-normal text-gray-700 mb-4">Cargar nuevos proyectos, generar QRs, editar o eliminar existentes.</p>
                    <span class="text-blue-600 font-bold text-sm">Ir a Proyectos &rarr;</span>
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-green-50 transition transform hover:-translate-y-1">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h5 class="text-xl font-bold text-gray-900">Usuarios</h5>
                    </div>
                    <p class="font-normal text-gray-700 mb-4">Administrar colaboradores y permisos de acceso al sistema.</p>
                    <span class="text-green-600 font-bold text-sm">Ir a Usuarios &rarr;</span>
                </a>
                @endif

                <a href="{{ url('/') }}" target="_blank" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 transition transform hover:-translate-y-1">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-gray-100 text-gray-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </div>
                        <h5 class="text-xl font-bold text-gray-900">Ver Web Pública</h5>
                    </div>
                    <p class="font-normal text-gray-700 mb-4">Ver cómo ven el sitio los vecinos actualmente.</p>
                    <span class="text-gray-600 font-bold text-sm">Ir al Sitio &rarr;</span>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>