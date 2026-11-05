<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;



uses(TestCase::class, RefreshDatabase::class);

it('recupera un grupo con su curso y sus atributos', function () {
    $curso = Curso::factory()->create([
        'sigla' => 'IF6100',
        'nombre_curso' => 'Análisis y Diseño de Sistemas',
        'creditos' => 4,
    ]);

    Grupo::factory()->create([
        'curso_id' => $curso->id,
        'numero_ciclo' => 2,
        'ano' => 2026,
        'numero_grupo' => 1,
        'abierto' => true,
    ]);

    $grupo = Grupo::query()->firstOrFail();

    expect(Grupo::query()->count())->toBe(1)
        ->and($grupo->numero_ciclo)->toBe(2)
        ->and($grupo->ano)->toBe(2026)
        ->and($grupo->numero_grupo)->toBe(1)
        ->and($grupo->abierto)->toBeTrue()
        ->and($grupo->curso->sigla)->toBe('IF6100')
        ->and($grupo->curso->creditos)->toBe(4);
});

it('obtiene los grupos de un curso y distingue los abiertos', function () {
    $curso = Curso::factory()->create([
        'sigla' => 'IF6100',
        'nombre_curso' => 'Análisis y Diseño de Sistemas',
        'creditos' => 4,
    ]);

    Grupo::factory()->createMany([
        ['curso_id' => $curso->id, 'numero_grupo' => 1, 'abierto' => true],
        ['curso_id' => $curso->id, 'numero_grupo' => 2, 'abierto' => true],
        ['curso_id' => $curso->id, 'numero_grupo' => 3, 'abierto' => false],
    ]);

    $curso->load('grupos');

    expect($curso->grupos)->toHaveCount(3)
        ->and($curso->grupos->where('abierto', true))->toHaveCount(2)
        ->and($curso->grupos->pluck('curso_id')->unique())->toHaveCount(1);
});

it('asigna dos docentes a un grupo y relaciona sus grupos', function () {
    $grupo = Grupo::factory()->create();
    $docenteUno = Docente::factory()->create(['cod_empleado' => 1001]);
    $docenteDos = Docente::factory()->create(['cod_empleado' => 1002]);

    $grupo->asignarDocente($docenteUno)->asignarDocente($docenteDos);
    $grupo->load('docentes');

    expect($grupo->docentes)->toHaveCount(2)
        ->and($grupo->docentes->pluck('cod_empleado')->all())->toEqualCanonicalizing([1001, 1002])
        ->and($docenteUno->fresh()->grupos->contains($grupo))->toBeTrue();
});

it('rechaza asignar un tercer docente al grupo', function () {
    $grupo = Grupo::factory()->create();
    $docentes = Docente::factory()->createMany([
        ['cod_empleado' => 1001],
        ['cod_empleado' => 1002],
        ['cod_empleado' => 1003],
    ]);

    $grupo->asignarDocente($docentes[0])
        ->asignarDocente($docentes[1]);

    expect(fn () => $grupo->asignarDocente($docentes[2]))
        ->toThrow(DomainException::class);

    expect($grupo->fresh()->docentes)->toHaveCount(2)
        ->and($grupo->fresh()->docentes->contains($docentes[2]))->toBeFalse();
});

it('no permite abrir un grupo con catorce estudiantes', function () {
    $grupo = Grupo::factory()->create(['abierto' => false]);
    $docente = Docente::factory()->create(['cod_empleado' => 1001]);
    $estudiantes = Estudiante::factory()->count(14)->create();

    $grupo->asignarDocente($docente);
    $grupo->estudiantes()->attach($estudiantes->modelKeys());

    expect($grupo->puedeAbrirse())->toBeFalse();
    expect(fn () => $grupo->abrir())->toThrow(DomainException::class);
    expect($grupo->fresh()->abierto)->toBeFalse();
});

it('abre un grupo con quince estudiantes y un docente', function () {
    $grupo = Grupo::factory()->create(['abierto' => false]);
    $docente = Docente::factory()->create(['cod_empleado' => 1001]);
    $estudiantes = Estudiante::factory()->count(15)->create();

    $grupo->asignarDocente($docente);
    $grupo->estudiantes()->attach($estudiantes->modelKeys());

    expect($grupo->puedeAbrirse())->toBeTrue();

    $grupo->abrir();

    expect($grupo->fresh()->abierto)->toBeTrue();
});
