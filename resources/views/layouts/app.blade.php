<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Projeto')</title>
    <link rel="stylesheet" href="{{ file_exists(public_path('mix-manifest.json')) ? mix('css/app.css') : asset('css/app.css') }}">
    <style>
        /* App background and basic color adjustments */
        body {
            background-color: cornflowerblue;
            min-height: 100vh;
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body>

@include('partials.header')

<main>
    @yield('content')
    CONTENT HERE
</main>

@include('partials.footer')
</body>
</html>
