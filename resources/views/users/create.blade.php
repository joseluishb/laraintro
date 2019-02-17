@extends('layout')

@section('title', "Crear Usuario")

@section('content')
    <h1>Crear Usuario</h1>

    <form method="post" action="{{ url('/usuarios') }}">
        {!! csrf_field() !!}
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" placeholder="ex. Juan Pérez">
        <br>
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email" placeholder="jperez@example.com">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" placeholder="mayor a 6 caracteres">
        <br>
        <button type="submit">Crear usuario</button>
    </form>


    <p>
        <a href="{{ route('users.index') }}">Regresar a usuarios</a>
    </p>
@endsection