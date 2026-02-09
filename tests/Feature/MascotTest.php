<?php

use App\Models\User;
use App\Models\Mascot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, get, assertDatabaseHas};

// Forzamos que la base de datos se limpie en cada intento
uses(RefreshDatabase::class);

test('un usuario puede ver la lista de mascotas', function () {
    // Creamos el usuario
    $user = User::factory()->create();

    // Intentamos entrar a la ruta de Filament
    actingAs($user)
        ->get('/admin/mascots')
        ->assertStatus(200);
});

test('se puede crear una mascota en la base de datos', function () {
    $user = User::factory()->create();

    // Importante: He puesto 'owner_id' porque tu error decía que esa columna faltaba
    Mascot::create([
        'name'      => 'RockyTest',
        'species'   => 'Perro',
        'breed'     => 'Boxer',
        'gender'    => 'Macho',
        'weight'    => 20.5,
        'birthdate' => '2020-01-01',
        'owner_id'  => $user->id, // <--- Esta es la clave del error anterior
    ]);

    assertDatabaseHas('mascots', [
        'name'     => 'RockyTest',
        'owner_id' => $user->id,
    ]);
});
