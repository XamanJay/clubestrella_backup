@extends('layouts.app')

@section('content')


<div class="home-wrapper">
    @if (session('status'))
        <div class="alert alert-success alert-home" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <img src="{{ asset('img/logos/clubestrella_gold.png') }}" class="center-item" id="goldLogo" alt="Club Estrella">
    <div class="container">
        <h1 class="center-text gold-title cinzel-font font-thick margin-sides">Bienvenido <br> a Club Estrella</h1>
        <div class="center-item margin-sides" id="textPrograma">
            <p class="center-text white-T cinzel-font">El programa de recompensas para el viajero frecuente, creado para reconocer su preferencia mediante beneficios exclusivos.</p>
        </div>
        <div class="center-item center-text btn-register">
            @if (Route::has('register'))
                <a href="{{ route('register', App::getLocale()) }}" class="btn purple-T white-bg">@lang('home.register')</a>
            @endif
        </div>
        <h5 class="center-text gold-title cinzel-font font-thick margin-sides">COMIENZA A SUMAR PUNTOS CON NUESTROS SOCIOS:</h5>

        <div class="row" id="socios">
            <div class="col-12 col-sm-6 center-text margin-sides">
                <img src="{{ asset('img/socios/oktrip.png') }}" class="center-item img-fluid" alt="Agencia de Viajes Oktrip">
                <h5 class='title-socio margin-sx gold-title'>Oktrip Agencia de Viajes</h5>
                <div class="text-socio white-T center-item">
                    <p>Canjea tus puntos por estancias nacionales e internacionales en más de 2,000 hoteles y tours pagando con puntos, cash y tarjetas de credito.</p>
                </div>
                <a href="{{ url('') }}" class="purple-T cinzel-font">Canjear Puntos</a>
            </div>
            <div class="col-12 col-sm-6 center-text margin-sides">
                <img src="{{ asset('img/socios/hotel_adhara.png') }}" class="center-item img-fluid" alt="Hotel Adhara Cancún">
                <h5 class='title-socio margin-sx gold-title'>Hotel Adhara Cancún</h5>
                <div class="text-socio white-T center-item">
                    <p>Beneficio y tarifas preferenciales en Hotel Adhara Cancún.</p>
                </div>
                <a href="{{ url('') }}" class="purple-T cinzel-font">Canjear Puntos</a>
            </div>
            <div class="col-12 col-sm-6 center-text margin-sides">
                <img src="{{ asset('img/socios/eventos_adhara.png') }}" class="center-item img-fluid" alt="Eventos Adhara Cancún">
                <h5 class='title-socio margin-sx gold-title '>Eventos Adhara</h5>
                <div class="text-socio white-T center-item">
                    <p>Recompensas para tu evento en Hotel Adhara Cancún.</p>
                </div>
                <a href="{{ url('') }}" class="purple-T cinzel-font">Canjear Puntos</a>
            </div>
            <div class="col-12 col-sm-6 center-text margin-sides">
                <img src="{{ asset('img/socios/rewards_clubestrella.png') }}" class="center-item img-fluid" alt="Recompensas Club Estrella">
                <h5 class='title-socio margin-sx gold-title '>Recompensas</h5>
                <div class="text-socio white-T center-item">
                    <p>Cambia tus puntos por diferentes premios.</p>
                </div>
                <a href="{{ url('') }}" class="purple-T cinzel-font">Canjear Puntos</a>
            </div>
        </div>

    </div>
</div>

<p style="display: none;">Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>
@endsection



