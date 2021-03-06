@extends('layout')

@section('title', "Editar usuario")

@section('content')
    <h1>Crear nuevo usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Por favor corrija los errores debajo:</h5>
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ url("/usuarios/{$user->id}") }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" placeholder="ex. Juan Pérez" value="{{ old('name', $user->name) }}">
        {{--@if ($errors->has('name'))--}}
            {{--<p>{{ $errors->first('name') }}</p>--}}
        {{--@endif--}}
        <br>
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email" placeholder="jperez@example.com" value="{{ old('email', $user->email) }}">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" placeholder="mayor a 6 caracteres">
        <br>
        <button type="submit">Actualizar usuario</button>
    </form>


    <p>
        <a href="{{ route('users.index') }}">Regresar a usuarios</a>
    </p>
@endsection