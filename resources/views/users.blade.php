<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de usuarios - Jose</title>
</head>
<body>
<h1>{{ $title }}</h1>

    {{--@unless(empty($users))--}}
        {{--<ul>--}}
            {{--@foreach ($users as $user)--}}
                {{--<li>{{ $user }}</li>--}}
            {{--@endforeach--}}
        {{--</ul>--}}
    {{--@else--}}
        {{--<p>No hay usuarios registrados.</p>--}}
    {{--@endunless--}}



    <ul>
        @forelse ($users as $user)
            <li>{{ $user }}</li>
        @empty
            <li>No hay usuarios registrados.</li>
        @endforelse
    </ul>

    {{ time() }}


</body>
</html>