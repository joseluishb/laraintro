<?php

use App\Profession;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //SQL PLANO
        //$professions = DB::select('SELECT id FROM professions WHERE title="Desarrollador back-end"'); //mejor:
        //$professions = DB::select('SELECT id FROM professions WHERE title = ?', ['Desarrollador back-end']);
        //dd($professions); //obtener el id: = $professions[0]->id

        //CONSTRUCTOR DE CONSULTAS

        //$professions = DB::table('professions')->select('id')->take(1)->get();
        //$profession = DB::table('professions')->select('id')->first(); //$profession->id
        //dd($profession->id);

        //dd($profession->first()->id); //$professions[0]

//        $professionId = DB::table('professions')
//                        ->where('title', 'Desarrollador back-end')
//                        ->value('id');


        //dd($professionId);

        //METODOS MAGICOS
//        $professionId = DB::table('professions')
//            ->whereTitle('Desarrollador back-end')
//            ->value('id');

        $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');

        User::create([
            'name' => 'Jose Huaytalla',
            'email' => 'joseluishube@gmail.com',
            'password' => bcrypt('laravel'),
            'profession_id' => $professionId, //$professions[0]->id,
            'is_admin' => true,
        ]);

        factory(User::class)->create([
           'profession_id' => $professionId
        ]);


        factory(User::class)->create([
           'name' => 'Sabina'
        ]);

        factory(User::class)->create([
            'name' => 'Jose'
        ]);

        factory(User::class, 48)->create();



//        User::create([
//            'name' => 'Another user',
//            'email' => 'anouser@gmail.com',
//            'password' => bcrypt('laravel'),
//            'profession_id' => $professionId, //$professions[0]->id,
//        ]);
//
//        User::create([
//            'name' => 'Another user 2',
//            'email' => 'anouser2@gmail.com',
//            'password' => bcrypt('laravel'),
//            'profession_id' => null, //$professions[0]->id,
//        ]);
    }
}
