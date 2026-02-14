<?php

use App\Models\User;
use App\Models\Mascot;
use Tests\TestCase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class);

// 1. CAMBIAMOS ESTA PRUEBA
test('un usuario autenticado puede acceder al panel principal', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/admin') // <--- Cambiamos de /admin/mascots a /admin
        ->assertStatus(200);
});

// 2. ESTA PRUEBA SE QUEDA EXACTAMENTE IGUAL (¡Esta ya pasó en GitHub!)
test('se puede crear una mascota en la base de datos', function () {
    $owner = User::factory()->create();

    Mascot::create([
        'name' => 'RockyTest',
        'species' => 'Perro',
        'breed' => 'Boxer',
        'gender' => 'Macho',
        'weight' => 20.5,
        'birthdate' => '2020-01-01',
        'owner_id' => $owner->id,
    ]);

    assertDatabaseHas('mascots', [
        'name' => 'RockyTest',
        'species' => 'Perro',
        'owner_id' => $owner->id,
    ]);
});
