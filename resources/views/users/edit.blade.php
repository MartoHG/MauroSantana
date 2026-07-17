<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-mauro-dark leading-tight">
            {{ __('Editar usuario') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 sm:p-8">
            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  :value="old('name', $user->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                  :value="old('email', $user->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="role" :value="__('Rol')" />
                    <select name="role" id="role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-mauro-blue focus:ring-mauro-blue">
                        @foreach(\App\Enums\UserRole::options() as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', $user->role->value) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>

                <hr class="border-gray-200">

                <div>
                    <x-input-label for="password" :value="__('Nueva contraseña (opcional)')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                  autocomplete="new-password" />
                    <p class="mt-1 text-xs text-gray-500">Déjalo en blanco para conservar la contraseña actual.</p>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar nueva contraseña')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                  class="mt-1 block w-full" autocomplete="new-password" />
                </div>

                <div class="flex items-center justify-end gap-4 pt-2">
                    <a href="{{ route('users.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">Cancelar</a>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-mauro-blue px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-mauro-blue-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-mauro-blue-dark focus-visible:ring-offset-2">
                        Actualizar usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
