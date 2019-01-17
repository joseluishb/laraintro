<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /** @test */
    function it_welcomes_users_with_nickname()
    {
        $this->get('/saludo/jose/shutz')
            ->assertStatus(200)
            ->assertSee('Bienvenido Jose, tu apodo es shutz');
    }

    /** @test */
    function it_welcomes_users_without_nickname()
    {
        $this->get('/saludo/jose')
            ->assertStatus(200)
            ->assertSee('Bienvenido Jose');
    }
}
