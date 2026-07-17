<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-mauro-dark leading-tight">
            {{ __('Nuevo documento') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 sm:p-8">

            @if($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <p class="font-semibold">Revisá los siguientes puntos:</p>
                    <ul class="mt-1 list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="tipo" :value="__('Tipo de documento')" />
                    <select name="tipo" id="tipo"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-mauro-blue focus:ring-mauro-blue">
                        @foreach(['Proyecto', 'Ordenanza'] as $tipo)
                            <option value="{{ $tipo }}" @selected(old('tipo') === $tipo)>{{ $tipo }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipo')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="titulo" :value="__('Título')" />
                    <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo')" required />
                    <x-input-error :messages="$errors->get('titulo')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="categoria" :value="__('Categoría')" />
                    <select name="categoria" id="categoria"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-mauro-blue focus:ring-mauro-blue">
                        @foreach(['Salud', 'Obras Públicas', 'Educación', 'Social', 'Deporte', 'Otros'] as $cat)
                            <option value="{{ $cat }}" @selected(old('categoria') === $cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categoria')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="fecha" :value="__('Fecha de presentación')" />
                    <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full" :value="old('fecha')" required />
                    <x-input-error :messages="$errors->get('fecha')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="descripcion" :value="__('Descripción (opcional)')" />
                    <textarea name="descripcion" id="descripcion" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-mauro-blue focus:ring-mauro-blue">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="pdf" :value="__('Archivo PDF')" />
                    <input type="file" name="pdf" id="pdf" accept="application/pdf"
                           class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-mauro-blue-light file:px-4 file:py-2 file:text-sm file:font-semibold file:text-mauro-blue-dark hover:file:bg-mauro-blue-soft" required>
                    <x-input-error :messages="$errors->get('pdf')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="imagen" :value="__('Imagen de portada (opcional)')" />
                    <input type="file" name="imagen" id="imagen" accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200">
                    <x-input-error :messages="$errors->get('imagen')" class="mt-1" />
                </div>

                <div class="flex items-center justify-end gap-4 pt-2">
                    <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">Cancelar</a>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-mauro-blue px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue-dark focus-visible:ring-offset-2">
                        Guardar documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
