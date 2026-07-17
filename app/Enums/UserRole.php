<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Colaborador = 'colaborador';

    /**
     * Etiqueta legible para mostrar en la interfaz.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Colaborador => 'Colaborador',
        };
    }

    /**
     * Solo los administradores gestionan usuarios.
     */
    public function canManageUsers(): bool
    {
        return $this === self::Admin;
    }

    /**
     * Administradores y colaboradores gestionan proyectos.
     */
    public function canManageProjects(): bool
    {
        return in_array($this, [self::Admin, self::Colaborador], true);
    }

    /**
     * Normaliza los valores heredados (mayúsculas, "Administrador", etc.)
     * a un caso válido del enum. Cualquier valor desconocido cae en Colaborador.
     */
    public static function fromLegacy(?string $value): self
    {
        return match (strtolower(trim((string) $value))) {
            'admin', 'administrador' => self::Admin,
            default => self::Colaborador,
        };
    }

    /**
     * Opciones para poblar los <select> de los formularios: [valor => etiqueta].
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $carry, self $role) => $carry + [$role->value => $role->label()],
            [],
        );
    }
}
