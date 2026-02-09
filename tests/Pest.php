<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class // ESTO CREA LAS TABLAS AL TESTEAR
)->in('Feature');
