<?php

use App\Models\Course;

it('returns courses when opening the API link', function () {
    Course::factory()->create([
        'name' => 'Diseño de Sistemas',
    ]);

    $response = $this->getJson('/api/courses');

    $response
        ->assertOk()
        ->assertJsonFragment(['name' => 'Diseño de Sistemas']);
});

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
