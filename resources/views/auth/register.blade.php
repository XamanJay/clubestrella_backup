@extends('layouts.app')

@section('page-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card cardRegister">
                <div class="card-header center-text">@lang('auth.titleRegister')</div>
                <div class="card-body">
                    @if (session('warnings'))
   
                        <div class="alert alert-danger " >
                            <ul style="list-style: none;">
                                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$warning[0]}}</li>
                            </ul>
                        </div>
                    @endif
                    @if (session('user_error'))
                        <div class="alert alert-danger " >
                            <ul style="list-style: none;">
                                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{ session('user_error') }}</li>
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('register', App::getLocale()) }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="nombre" class="col-form-label text-md-right">@lang('auth.name') <span class="mustInput">*</span></label>
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ Request::old('nombre') }}" autocomplete="nombre" autofocus>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos" class="col-form-label text-md-right">@lang('auth.lastName')<span class="mustInput">*</span></label>
                                <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ Request::old('apellidos') }}" autocomplete="apellidos">
                                @error('apellidos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="password" class="col-form-label text-md-right">@lang('auth.password')<span class="mustInput">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="col-form-label text-md-right">@lang('auth.confirm_password')<span class="mustInput">*</span></label>
                                <input id="confirm_password" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="current-confirm_password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">  
                            <div class="col-md-6">
                                <label for="email" class="col-form-label text-md-right">@lang('auth.email')<span class="mustInput">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Request::old('email') }}" autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="celular" class="col-form-label text-md-right">@lang('auth.phone')<span class="mustInput">*</span></label>
                                <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ Request::old('celular') }}" autocomplete="celular">
                                @error('celular')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="empresa" class="col-form-label text-md-right">@lang('auth.company')</label>
                                <input id="empresa" type="text" class="form-control" name="empresa" value="{{ Request::old('empresa') }}" autocomplete="empresa">
                            </div>
                            <div class="col-md-6">
                                <label for="rfc_company" class="col-form-label text-md-right">@lang('auth.rfc_company')</label>
                                <input id="rfc_company" type="text" class="form-control" name="rfc_company" value="{{ Request::old('rfc_company') }}" >
                            </div>
                            <div class="col-md-6">
                                <label for="pais" class="col-form-label text-md-right">@lang('auth.country')<span class="mustInput">*</span></label>
                                <select name="pais" id="pais" class="form-control">
                                    @if (Request::old('pais'))
                                        @foreach ($paises as $pais)
                                            @if ($pais->nombre == Request::old('pais'))
                                                <option value="{{ $pais->nombre }}" selected>{{ $pais->nombre }}</option>
                                                @else 
                                                <option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>   
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($paises as $pais)
                                            @if ($pais->nombre == Request::old('pais'))
                                                <option value="{{ $pais->nombre }}" selected>{{ $pais->nombre }}</option>
                                                @else 
                                                <option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>   
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="ciudad" class="col-form-label text-md-right">@lang('auth.city')</label>
                                <input id="ciudad" type="text" class="form-control" name="ciudad" value="{{ Request::old('ciudad') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="estado" class="col-form-label text-md-right">@lang('auth.state')</label>
                                <input id="estado" type="text" class="form-control" name="estado" value="{{ Request::old('estado') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="cp" class="col-form-label text-md-right">@lang('auth.cp_')</label>
                                <input id="cp" type="text" class="form-control" name="cp" value="{{ Request::old('cp') }}" autocomplete="cp">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="direccion" class="col-form-label text-md-right">@lang('auth.address')</label>
                                <input id="direccion" type="text" class="form-control" name="direccion" value="{{ Request::old('direccion') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-edit">
                                    @lang('auth.send')
                                </button>
                                <div class="spinner">
                                    <div class="rect1"></div>
                                    <div class="rect2"></div>
                                    <div class="rect3"></div>
                                    <div class="rect4"></div>
                                    <div class="rect5"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("#pais").select2();
    $(document).ready(function(){
        $(".btn-edit").click(function(){
            $(".btn-edit").css('display','none');
            $(".btn-danger").css('display','none');
            $(".spinner").css('display','block');
        });    
    });
</script>
@endsection
