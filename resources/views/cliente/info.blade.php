@extends('layouts.app')

@section('page-styles')
    <script src="{{ asset('js/datedropper.pro.min.js') }}"></script>
@endsection

@section('content')

<div class="container">
    <div class="headline" style="margin-top: 50px;">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1 class="gold-title cinzel-font"><small style="font-size: 15px;">SR.</small> {{ $user['data']['nombre'] }}</h1>
            </div>
            <div class="col-12 col-sm-6 info-client">
                <img src="{{ asset('img/icons/coins.png') }}" alt="Puntos Clubestrella" id="points-img">
                <p>Puntos: {{ number_format($user['data']['puntos']['puntos_totales']) }}</p>
                <p>E-mail: {{ $user['data']['email']}}</p>
                <p>Empresa: {{ $user['data']['cliente']['empresa']}}</p>
                <p>Número de Socio: {{ $user['data']['cliente']['numero_socio']}}</p>
                <p>Fecha de Registro: {{ \Carbon\Carbon::parse( $user['data']['created_at'])->format('d/m/Y') }}</p>
            </div>
        </div>   
    </div>
    <a href="{{ route('update-perfil',App::getLocale()) }}" class="edit-link"> <i class="fas fa-user-edit"></i> Editar Perfil</a>
</div>



@endsection

@section('page-scripts')
    
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
@endsection
