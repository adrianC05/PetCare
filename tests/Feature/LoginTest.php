<?php

use function Pest\Laravel\get;

test('la página de login carga correctamente', function () {
    // Si usas Filament, la ruta suele ser /admin/login
    get('/admin/login')
        ->assertStatus(200)
        ->assertSee('Sign in'); // O el texto que aparezca en tu login
});
