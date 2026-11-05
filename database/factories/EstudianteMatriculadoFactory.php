<?php

namespace Database\Factories;

use App\Models\Estudiante;
use App\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstudianteMatriculadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'grupo_id' => Grupo::factory(),
            'estudiante_id' => Estudiante::factory(),
            'nota' => null,
        ];
    }
}
