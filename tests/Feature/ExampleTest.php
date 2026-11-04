<?php

test('the application returns a successful response', function () {
    
    $data = [
        'codCarrera' => 'ING123',
        'nombre' => 'Ingeniería en Sistemas'
    ];

    $response = $this->post('/carreras', $data);

    $response->assertStatus(201);
    
    $this->assertDatabaseHas('carreras', [
        'codCarrera' => 'ING123',
        'nombre' => 'Ingeniería en Sistemas'
    ]);
});
