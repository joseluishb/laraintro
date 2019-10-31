@extends('layout')

@section('title', "Crear Usuario")

@section('content')
    <div class="card">
        <h4 class="card-header">Crear nuevo usuario</div>
        <div class="card-body">
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
        
            <form method="post" action="{{ url('/usuarios') }}">
                {!! csrf_field() !!}
        
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="ex. Juan Pérez" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="jperez@example.com" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="mayor a 6 caracteres">
                </div>
                <button type="submit" class="btn btn-primary">Crear usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar a usuarios</a>
        
            </form>
        </div>
    </div>


@endsection