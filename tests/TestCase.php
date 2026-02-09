<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // En Laravel 11+ esto suele venir vacío o usar CreatesApplication
    // Si usas una versión anterior (Laravel 10 o menos), asegúrate de tener:
    use CreatesApplication;
}
