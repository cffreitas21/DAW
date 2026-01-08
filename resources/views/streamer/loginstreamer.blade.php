@extends('layouts.app')

@section('content')
    <style>
        {!! file_get_contents(resource_path('views/streamer/streamer.css')) !!}
    </style>

    <main class="nb-login-page" role="main">
        <div class="nb-login-backdrop"></div>

        <div class="nb-login-card" aria-labelledby="nb-login-title">
            <div class="nb-logo">Login Cinéfilo</div>

            <form class="nb-form" method="POST" action="#" aria-describedby="nb-login-desc">
                @csrf
                <label for="nb-email" class="nb-visually-hidden">Nome de Utilizador</label>
                <input id="nb-email" name="username" type="text" class="nb-input" placeholder="Nome de Utilizador" autocomplete="username" required>

                <label for="nb-password" class="nb-visually-hidden">Password</label>
                <input id="nb-password" name="password" type="password" class="nb-input" placeholder="Password" autocomplete="current-password" required>

                <button type="submit" class="nb-submit"
                        onclick="window.location.href='{{ url('/homepage') }}'">
                    Iniciar Sessão</button>

                <button type="button" class="nb-submit"
                        onclick="window.location.href='{{ url('/loginadm') }}'">
                    Iniciar Sessão como Administrador
                </button>

                <div class="nb-signup">
                    Novo Utilizador? <a href="#">Sign up now</a>.
                </div>
            </form>
        </div>
    </main>
@endsection
