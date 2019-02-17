@extends('layout')

@section('title', "Crear Usuario")

@section('content')
    <h1>Crear Usuario</h1>

    <form method="post" action="{{ url('/usuarios') }}">
        {!! csrf_field() !!}
        <button type="submit">Crear usuario</button>
    </form>


    <p>
        <a href="{{ route('users.index') }}">Regresar a usuarios</a>
    </p>
@endsection