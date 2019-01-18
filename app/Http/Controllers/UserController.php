<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if(request()->has('empty')){
            $users = [];
        }else{
            $users = [
                'Sabina', 'Jose', 'Laura', 'Lili', 'Mariano', 'Nilda',

            ];
        }


        //Formas de pasar variables:
//        return view('users', [
//            'users' => $users,
//            'title' => 'Listado de usuarios'
//        ]);

//        return view('users')
//            ->with('users', $users)
//            ->with('title','Listado de usuarios');

        $title = 'Listado de usuarios';

        //dd(compact('ttle', 'users'));

        return view('users.index', compact('title', 'users'));

    }

    public function show($id)
    {
        return view('users.show', compact('id'));
    }

    public function create()
    {
        return 'Crear nuevo usuario';
    }
}
