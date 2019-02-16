<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        //        if(request()->has('empty')){
        //            $users = [];
        //        }else{
        //            $users = [
        //                'Sabina', 'Jose', 'Laura', 'Lili', 'Mariano', 'Nilda',
        //            ];
        //        }


                //Formas de pasar variables:
        //        return view('users', [
        //            'users' => $users,
        //            'title' => 'Listado de usuarios'
        //        ]);

        //        return view('users')
        //            ->with('users', $users)
        //            ->with('title','Listado de usuarios');

        //$users = DB::table('users')->get();
        $users = User::all();
        $title = 'Listado de usuarios';
        //dd(compact('ttle', 'users'));

//        return view('users.index')
//            ->with('users', User::all())
//            ->with('title','Listado de usuarios');

        return view('users.index', compact('title', 'users'));

    }

    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return 'Crear nuevo usuario';
    }
}
