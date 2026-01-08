@extends('layouts.app')

@section('content')
    <style>
        {!! file_get_contents(resource_path('views/admin/admin.css')) !!}
    </style>

    <div class="top-bar-box">
        <div class="top-bar">
            <div class="name-topbar">
                <button type="submit" class="nb-submit"
                        onclick="window.location.href='{{ url('/homepageadm') }}'">
                    Aprovação de Avaliações</button>
                <button>Estatísticas</button>
            </div>

            <div class="top-bar-spacer" style="flex:1;"></div>
        </div>
    </div>

    PAGINA DE ADICIONAR FILME DO ADMIN
@endsection
