<?php

use App\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Normaliza los valores heredados de la columna `role`
     * (p. ej. "Admin", "Administrador", "Colaborador") a los valores
     * canónicos del enum: `admin` / `colaborador`.
     *
     * Es imprescindible antes de castear `role` a UserRole en el modelo:
     * Eloquent lanza un ValueError al hidratar un valor fuera del enum.
     */
    public function up(): void
    {
        // Administradores: cualquier variante de mayúsculas o "Administrador".
        DB::table('users')
            ->whereRaw('LOWER(role) IN (?, ?)', ['admin', 'administrador'])
            ->update(['role' => UserRole::Admin->value]);

        // Todo lo demás (incluye variantes de "Colaborador" y valores inválidos)
        // pasa a colaborador.
        DB::table('users')
            ->where('role', '!=', UserRole::Admin->value)
            ->update(['role' => UserRole::Colaborador->value]);
    }

    /**
     * La normalización de datos no es reversible (se pierde el casing original).
     */
    public function down(): void
    {
        // Sin acción: no se puede reconstruir el valor previo.
    }
};
