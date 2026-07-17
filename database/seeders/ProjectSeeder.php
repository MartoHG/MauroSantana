<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $autores = User::all();

        if ($autores->isEmpty()) {
            $autores = User::factory(2)->create();
        }

        Project::factory()
            ->count(15)
            ->state(fn () => ['user_id' => $autores->random()->id])
            ->create();
    }
}
