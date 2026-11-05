<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class GrupoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curso_id' => Curso::factory(),
            'numero_ciclo' => fake()->numberBetween(1, 3),
            'ano' => fake()->year(),
            'numero_grupo' => fake()->numberBetween(1, 9),
            'abierto' => false,
        ];
    }
}
