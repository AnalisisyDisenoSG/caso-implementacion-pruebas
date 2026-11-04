<?php

use App\Models\Course;

it('creates a course and saves it in the database', function () {
    $courseData = [
        'name' => 'Diseño de Sistemas',
        'description' => 'Curso de análisis y diseño de sistemas.',
    ];

    $response = $this->postJson('/api/courses', $courseData);

    $response
        ->assertCreated()
        ->assertJsonPath('name', $courseData['name'])
        ->assertJsonPath('description', $courseData['description']);

    $this->assertDatabaseHas('courses', $courseData);
    expect(Course::query()->count())->toBe(1);
});
