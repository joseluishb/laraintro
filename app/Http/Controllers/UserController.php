<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function show(User $user) //show($id)
    {
        //$user = User::findOrFail($id);

// ó

//        $user = User::find($id);
//
//        if($user == null){
//            return response()->view('errors.404',[],404);
//        }

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }



    public function store()
    {
        // validacion con validate
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email', //['required','email','unique']
            'password' => 'required'
        ],[
            'name.required' => 'El campo nombre es obligatorio'
        ]);

        //validacion propia
//        $data = request()->all();
//
//        if(empty($data['name'])){
//            return redirect('usuarios/nuevo')->withErrors([
//               'name' => 'El campo nombre es obligatorio'
//            ]);
//        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        //$data = request()->all();
        $data = request()->validate([
            'name' => 'required',
            //'email' => 'required|email|unique:users,email, '.$user->id, // ó
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],

            'password' => '',
        ]);

        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }


        $user->update($data);


        //return redirect("usuarios/{$user->id}");
        return redirect()->route('users.show',['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
