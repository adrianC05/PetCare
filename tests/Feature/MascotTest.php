<?php

use App\Models\User;
use App\Models\Mascot;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

test('un usuario autenticado puede acceder al panel principal', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/admin')
        ->assertStatus(200);
});

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
