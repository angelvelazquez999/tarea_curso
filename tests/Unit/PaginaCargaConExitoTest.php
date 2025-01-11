<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\TestCase;

class PaginaCargaConExitoTest extends BaseTestCase
{

    public function test_pagina_bienvenida_contenido()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Laravel');
    }
}
