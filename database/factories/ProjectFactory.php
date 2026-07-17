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
     * Mismas categorías que ofrecen los formularios de carga/edición.
     */
    private const CATEGORIAS = ['Salud', 'Obras Públicas', 'Educación', 'Social', 'Deporte', 'Otros'];

    /**
     * Temas plausibles de labor legislativa municipal, para que los datos
     * de prueba se lean como proyectos/ordenanzas reales.
     */
    private const TEMAS = [
        'Creación de un centro de salud barrial',
        'Ampliación del sistema de recolección de residuos',
        'Construcción de veredas accesibles en el macrocentro',
        'Boleto estudiantil gratuito para nivel secundario',
        'Promoción del turismo local en temporada baja',
        'Regulación del uso de espacios públicos costeros',
        'Apoyo a emprendedores y comercios locales',
        'Plan de forestación urbana',
        'Mejora del alumbrado público en barrios periféricos',
        'Creación de un polideportivo municipal',
        'Declaración de interés cultural de la Fiesta del Salmón',
        'Programa de becas municipales para estudiantes',
        'Instalación de cámaras de seguridad en accesos a la ciudad',
        'Adhesión a la ley provincial de discapacidad',
        'Creación del registro municipal de organizaciones vecinales',
    ];

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo = fake()->randomElement(['Proyecto', 'Ordenanza']);
        $numero = fake()->unique()->numberBetween(1, 999);
        $tema = fake()->randomElement(self::TEMAS);

        return [
            'titulo' => "{$tipo} N° {$numero}: {$tema}",
            'tipo' => $tipo,
            'descripcion' => fake()->boolean(70) ? fake()->paragraph() : null,
            'fecha' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'categoria' => fake()->randomElement(self::CATEGORIAS),
            'estado' => 'publicado',
            'pdf_path' => 'pdfs/'.fake()->uuid().'.pdf',
            'pdf_hash' => hash('sha256', fake()->unique()->uuid()),
            'qr_path' => 'qrs/qr_'.fake()->uuid().'.svg',
            'imagen_path' => null,
            'user_id' => User::factory(),
        ];
    }
}
