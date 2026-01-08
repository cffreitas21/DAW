@extends('layouts.app')

@section('content')
    <style>
        {!! file_get_contents(resource_path('views/streamer/streamer.css')) !!}
    </style>

    <div class="top-bar-box">
        <div class="top-bar">
            <div class="name-topbar">
                <button type="submit" class="nb-submit"
                        onclick="window.location.href='{{ url('/homepage') }}'">
                    Ver Filmes Recomendados</button>
            </div>
            <div class="top-bar-spacer" style="flex:1;"></div>
        </div>
    </div>

    PAGINA DE DETALHES DO FILME DO STREAMER
@endsection
