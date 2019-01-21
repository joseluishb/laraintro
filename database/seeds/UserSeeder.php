<?php

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
        DB::table('users')->insert([
            'name' => 'Jose Huaytalla',
            'email' => 'joseluishube@gmail.com',
            'password' => bcrypt('laravel'),
        ]);
    }
}
