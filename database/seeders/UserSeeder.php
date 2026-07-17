<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Cuentas base para desarrollo: una root (administrador) y una colaborador.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'root@maurosantana.test'],
            [
                'name' => 'Root',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ],
        );

        User::updateOrCreate(
            ['email' => 'colaborador@maurosantana.test'],
            [
                'name' => 'Colaborador',
                'password' => Hash::make('password'),
                'role' => UserRole::Colaborador,
            ],
        );
    }
}
