<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return "Hello!!!";
    //return view('welcome');
});


Route::get('/usuarios', 'UserController@index')
    ->name('users.index');

//antes {id} ahora {user}
Route::get('/usuarios/{user}', 'UserController@show')
    ->where('user','[0-9]+')
    ->name('users.show');

//Route::get('/usuarios/{id}', function ($id) {
//    return "Mostrando detalle del usuario: {$id}";
//})->where('id','[0-9]+');

Route::get('/usuarios/nuevo', 'UserController@create')->name('users.create');

Route::get('/usuarios/{user}/editar', 'UserController@edit')->name('users.edit');




Route::post('/usuarios', 'UserController@store');

Route::get('/saludo/{name}/{nickname?}', 'WelcomeUserController');
