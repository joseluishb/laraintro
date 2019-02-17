<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase; //trait *

    /** @test */
    function it_loads_the_users_list_page()
    {
        factory(User::class)->create([
            'name' => 'Sabina'
        ]);

        factory(User::class)->create([
            'name' => 'Jose'
        ]);


        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Sabina')
            ->assertSee('Jose');
    }


    /** @test */
    function it_show_a_default_message_if_the_users_list_is_empty()
    {
        //DB::table('users')->truncate(); // descomentar sino se usa trait *

        $this->get('/usuarios?empty')
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados.');
    }

    /** @test */
    function it_displays_the_users_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Laura Escobar'
        ]);

        $this->get('/usuarios/'.$user->id) //usuarios/5
            ->assertStatus(200)
            ->assertSee('Laura Escobar');
    }

    /** @test */
    public function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('/usuarios/999')
        ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /** @test */
    function it_loads_the_new_users_page()
    {
        $this->withoutExceptionHandling(); //llamar este método para visualizar el error

        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario');
    }

    /** @test */
    public function it_creates_a_new_user()
    {
        //$this->withoutExceptionHandling(); //para revelar que errores hay

//        $this->post('/usuarios',[
//            'name' => 'Jose Luis HB',
//            'email' => 'joseluishube@gmail.com',
//            'password' => '123456'
//        ])->assertSee('Procesando información...');

        $this->post('/usuarios',[
            'name' => 'Jose Luis HB',
            'email' => 'joseluishube@gmail.com',
            'password' => '123456'
        ])->assertRedirect('usuarios');

//        $this->assertDatabaseHas('users',[
//            'name' => 'Jose Luis HB',
//            'email' => 'joseluishube@gmail.com',
//            //'password' => '123456'
//        ]);

        $this->assertCredentials([
            'name' => 'Jose Luis HB',
            'email' => 'joseluishube@gmail.com',
            'password' => '123456'
        ]);
    }

    /** @test */
    public function the_name_is_required()
    {
        $this->withoutExceptionHandling();

        $this->post('/usuarios',[
            'name' => '',
            'email' => 'joseluishube@gmail.com',
            'password' => '123456'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);


        $this->assertDatabaseMissing('users',[
            'email' => 'joseluishube@gmail.com',
        ]);
    }
}
