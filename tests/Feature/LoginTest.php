<?php

use function Pest\Laravel\get;

test('la página de login carga correctamente', function () {
    get('/admin/login')
        ->assertStatus(200)
        ->assertSee('PetCare');
});
