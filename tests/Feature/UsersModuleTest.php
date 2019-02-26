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
        $this->withoutExceptionHandling(); //para revelar que errores hay

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
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => '',
                'email' => 'joseluishube@gmail.com',
                'password' => '123456'
        ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);


        $this->assertEquals(0,User::count());

//        $this->assertDatabaseMissing('users',[
//            'email' => 'joseluishube@gmail.com',
//        ]);
    }


    /** @test */
    public function the_email_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Jose L',
                'email' => '',
                'password' => '123456'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);


        $this->assertEquals(0,User::count());

    }

    /** @test */
    public function the_email_must_be_valid()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Jose L',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);


        $this->assertEquals(0,User::count());

    }

    /** @test */
    public function the_email_must_be_unique()
    {
        //$this->withoutExceptionHandling();

        factory(User::class)->create([
           'email' => 'jose@demo.com'
        ]);

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Jose L',
                'email' => 'jose@demo.com',
                'password' => '123456'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);


        $this->assertEquals(1,User::count());

    }

    /** @test */
    public function the_password_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Jose L',
                'email' => 'jlhb@demo.com',
                'password' => ''
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['password']);


        $this->assertEquals(0,User::count());

    }

    /** @test */
    function it_loads_the_edit_users_page()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar", ['id' => $user->id])
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            //->assertViewHas('user',$user);
            ->assertViewHas('user', function ($viewUser) use ($user){
                return $viewUser->id == $user->id;
            });

    }


    /** @test */
    public function it_updates_a_user()
    {
        $user = factory(User::class)->create();

        $this->withoutExceptionHandling(); //para revelar que errores hay

        $this->put("/usuarios/{$user->id}",[
            'name' => 'Jose Lui',
            'email' => 'joseluishubee@gmail.com',
            'password' => '123456'
        ])->assertRedirect("usuarios/{$user->id}");


        $this->assertCredentials([
            'name' => 'Jose Lui',
            'email' => 'joseluishubee@gmail.com',
            'password' => '123456'
        ]);
    }

    /** @test */
    public function the_name_is_required_when_updating_a_user()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name' => '',
                'email' => 'joseluishube@gmail.com',
                'password' => '123456'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);




        $this->assertDatabaseMissing('users',[
            'email' => 'joseluishube@gmail.com',
        ]);
    }

    /** @test */
    public function the_email_must_be_valid_when_updating_a_user()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Jooselo',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);




        $this->assertDatabaseMissing('users',[
            'name' => 'Jooselo',
        ]);
    }

    /** @test */
    public function the_email_must_be_unique_when_updating_a_user()
    {
        //$this->withoutExceptionHandling(); //ej: sale error 500 => lo descubrimos

//        self::markTestIncomplete();
//        return;


        $randomUser = factory(User::class)->create([
            'email' => 'existing-email@demo.com'
        ]);

        $user = factory(User::class)->create([
            'email' => 'jose@demo.com'
        ]);

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Jooselo',
                'email' => 'existing-email@demo.com',
                'password' => '123456'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);





    }

    /** @test */
    public function the_password_is_optional_when_updating_a_user()
    {
        //$this->withoutExceptionHandling();

        $oldPassword = 'CLAVE_ANTERIOR';

        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword)
        ]);

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Jooselo',
                'email' => 'jose@demo.com',
                'password' => ''
            ])
            ->assertRedirect("/usuarios/{$user->id}"); //(users.show)




        $this->assertCredentials([
            'name' => 'Jooselo',
            'email' => 'jose@demo.com',
            'password' => $oldPassword
        ]);
    }


    /** @test */
    public function the_users_email_can_stay_the_same_when_updating_the_user()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'joseluis@demo.com'
        ]);

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Jooselo',
                'email' => 'joseluis@demo.com',
                'password' => '12345678'
            ])
            ->assertRedirect("/usuarios/{$user->id}"); //(users.show)




        $this->assertDatabaseHas('users',[
            'name' => 'Jooselo',
            'email' => 'joseluis@demo.com',
        ]);
    }


    /** @test */
    public function it_deletes_a_user()
    {
        //$this->withoutExceptionHandling();


        $user = factory(User::class)->create([
            'email' => 'joseluis@demo.com'
        ]);


        $this->delete("/usuarios/{$user->id}")
            ->assertRedirect("usuarios");


        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
