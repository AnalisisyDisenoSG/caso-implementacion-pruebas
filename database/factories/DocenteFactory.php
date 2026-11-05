<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocenteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cod_empleado' => fake()->unique()->numberBetween(1000, 9999),
            'nombre' => fake()->firstName(),
            'apellidos' => fake()->lastName().' '.fake()->lastName(),
        ];
    }
}
