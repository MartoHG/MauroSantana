<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->unique()->sentence(4),
            'tipo' => fake()->randomElement(['Proyecto', 'Ordenanza']),
            'descripcion' => fake()->paragraph(),
            'fecha' => fake()->date(),
            'categoria' => fake()->randomElement(['Salud', 'Obras Públicas', 'Educación', 'Social']),
            'estado' => 'publicado',
            'pdf_path' => 'pdfs/'.fake()->uuid().'.pdf',
            'pdf_hash' => hash('sha256', fake()->unique()->uuid()),
            'qr_path' => 'qrs/'.fake()->uuid().'.svg',
            'imagen_path' => null,
            'user_id' => User::factory(),
        ];
    }
}
