{{-- Vista: Login do Administrador - Página de autenticação --}}
@extends('layouts.app')

@section('content')
    <style>
        {!! file_get_contents(resource_path('views/admin/admin.css')) !!}
    </style>

    <main class="nb-login-page" role="main">
        <div class="nb-login-backdrop"></div>

        <div class="nb-login-card" aria-labelledby="nb-login-title">
            <div class="nb-logo">Login Administrador</div>

            <form class="nb-form" method="POST" action="#" aria-describedby="nb-login-desc">
                @csrf
                <label for="nb-email" class="nb-visually-hidden">Nome de Utilizador</label>
                <input id="nb-email" name="username" type="text" class="nb-input" placeholder="Nome de Utilizador" autocomplete="username" required>

                <label for="nb-password" class="nb-visually-hidden">Password</label>
                <input id="nb-password" name="password" type="password" class="nb-input" placeholder="Password" autocomplete="current-password" required>

                <button type="submit" class="nb-submit"
                        onclick="window.location.href='{{ url('/homepageadm') }}'">
                    Iniciar Sessão</button>

                <button type="button" class="nb-submit" onclick="window.location.href='{{ url('/loginstreamer') }}'">
                    Iniciar Sessão como Cinéfilo
                </button>

            </form>
        </div>
    </main>
@endsection
