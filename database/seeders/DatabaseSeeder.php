<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@maurosantana.test'],
            [
                'name' => 'Mauro Santana',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ],
        );

        User::updateOrCreate(
            ['email' => 'colaborador@maurosantana.test'],
            [
                'name' => 'Colaborador de prueba',
                'password' => Hash::make('password'),
                'role' => UserRole::Colaborador,
            ],
        );
    }
}
