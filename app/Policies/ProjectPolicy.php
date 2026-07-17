<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Ver el listado de gestión de proyectos (panel).
     */
    public function viewAny(User $user): bool
    {
        return $user->canManageProjects();
    }

    /**
     * Ver un proyecto en el panel.
     */
    public function view(User $user, Project $project): bool
    {
        return $user->canManageProjects();
    }

    /**
     * Cargar un nuevo proyecto.
     */
    public function create(User $user): bool
    {
        return $user->canManageProjects();
    }

    /**
     * Editar un proyecto.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->canManageProjects();
    }

    /**
     * Eliminar un proyecto.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->canManageProjects();
    }
}
