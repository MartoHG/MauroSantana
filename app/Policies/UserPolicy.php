<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Ver el listado de usuarios: solo administradores.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Ver un usuario: solo administradores.
     */
    public function view(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Crear usuarios: solo administradores.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Editar usuarios: solo administradores.
     */
    public function update(User $user, User $target): bool
    {
        return $user->isAdmin();
    }

    /**
     * Eliminar usuarios: solo administradores, y nunca a sí mismo.
     */
    public function delete(User $user, User $target): bool
    {
        return $user->isAdmin() && $user->id !== $target->id;
    }
}
