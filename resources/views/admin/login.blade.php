@extends('layouts.login')


@section('content')
<div id="loginDialog">
    @if(session('error'))
        <div class="alert alert-danger center-text">
            <ul style="list-style: none;margin-bottom:0px;">
                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{session('error')}}</li>
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-6 col-sm-6 d-flex align-content-center flex-wrap justify-content-center">
            <img src="{{ asset('img/icons/travel.jpg') }}" alt="Login Club Estrella" style="width: 100%;">
        </div>
        <div class="col-6 col-sm-6" id="box-input">
            <img src="{{ asset('img/logos/clubestrella_gold.png') }}" alt="Club Estrella" id="loginStar">
            <h4>Iniciar Sesión</h4>
            <form action="{{ route('login-admin',App::getLocale()) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="email">Password</label>
                    <input type="password" class="form-control" name="password" id="password" aria-describedby="passwordHelp">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn login-admin">Login</button>
                </div>  
            </form>
        </div>
    </div>
</div>

@endsection

@section('page-scripts')   
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
@endsection
