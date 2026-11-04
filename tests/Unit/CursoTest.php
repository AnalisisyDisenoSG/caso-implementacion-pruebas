<?php

use App\Models\Curso;

test('probar que es una instancia de Curso', function () {
    
    $curso = Curso::factory()->create(); // arrange
  //  dd($curso); // debug
    // act & assert
    expect($curso)->toBeInstanceOf(Curso::class);
});

test('probar que un curso pertenece a una carrera', function () {
    $carrera = \App\Models\Carrera::factory()->create(['nombre' => 'Ingeniería en Sistemas']); // arrange
    $curso = Curso::factory()->create(['carrera_id' => $carrera->id]); // arrange
 
    // act & assert
    expect($curso->carrera)->toBeInstanceOf(\App\Models\Carrera::class);
  
});

test('probar que un curso pertenece a una carrera con nombre igual', function () {
    $carrera = \App\Models\Carrera::factory()->create(['nombre' => 'Ingeniería en Sistemas']); // arrange
    $curso = Curso::factory()->create(['carrera_id' => $carrera->id]); // arrange
 
    // act & assert
    expect($curso->carrera->nombre)->toBe($carrera->nombre);
});