<?php

namespace Database\Factories;

use App\Models\Piso;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\pisos>
 */
class PisosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'id' => fake()->unique()->randomNumber(2),
            'titulo' => fake()->sentence,
            'ciudad' => fake()->city,
            'zona' => fake()->word,
            'precio' => fake()->numberBetween(1000, 5000),
            'planta' => fake()->numberBetween(1, 10),
            'extension' => fake()->numberBetween(50, 200),
            'habitaciones' => fake()->numberBetween(1, 5),
            'baños' => fake()->numberBetween(1, 3),
            'descripcion' => fake()->paragraph,
            'caracteristicas' => json_encode([
                'parking' => fake()->boolean,
                'terraza' => fake()->boolean,
                'piscina' => fake()->boolean,
                'jardin' => fake()->boolean,
            ]),
            'fotos' => json_encode([
                fake()->imageUrl(),
                fake()->imageUrl(),
                fake()->imageUrl(),
            ]),
            'isFavorite' => fake()->boolean,
            'propietario' => fake()->name,
        ];
    }
}
