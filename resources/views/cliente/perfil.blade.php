@extends('layouts.app')

@section('page-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('update.perfil',App::getLocale()) }}" method="POST" class="perfil-form">
            @csrf
            <div class="row">
                <div class="col-12">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nombre">@lang('auth.name')</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="nombreHelp" value="{{ Request::old('nombre') ?? $response['data']['nombre'] }}">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="lastname">@lang('auth.lastName')</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="lastnameHelp" value="{{ Request::old('lastname') ?? $response['data']['apellidos'] }}">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="email">@lang('auth.email')</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{ Request::old('email') ?? $response['data']['email'] }}">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="country">@lang('auth.country')</label>
                        <select class="form-control pais_select" id="country" name="country">
                            @foreach ($paises as $pais)
                                @if ($pais->nombre == Request::old('country'))
                                <option value="{{ $pais->nombre }}" selected>{{ $pais->nombre }}</option>
                                @else 
                                <option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>   
                                @endif
                                
                            @endforeach
                        </select>     
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="city">@lang('auth.city')</label>
                        <input type="text" class="form-control" name="city" id="city" aria-describedby="cityHelp" value="{{ Request::old('city') ?? $response['data']['cliente']['ciudad'] }}">
                        
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="state">@lang('auth.state')</label>
                        <input type="text" class="form-control" name="state" id="state" aria-describedby="stateHelp" value="{{ Request::old('state') ?? $response['data']['cliente']['estado'] }}">
                        
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="address">@lang('auth.address')</label>
                        <input type="text" class="form-control" name="address" id="address" aria-describedby="addressHelp" value="{{ Request::old('address') ?? $response['data']['cliente']['direccion'] }}">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="phone">@lang('auth.phone')</label>
                        <input type="text" class="form-control" name="phone" id="phone" aria-describedby="phoneHelp" value="{{ Request::old('phone') ?? $response['data']['cliente']['celular'] }}">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="cp">@lang('auth.cp_')</label>
                        <input type="text" class="form-control" name="cp" id="cp" aria-describedby="cpHelp" value="{{ Request::old('cp') ?? $response['data']['cliente']['cp'] }}">
                        
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="company">@lang('auth.company')</label>
                        <input type="text" class="form-control" name="company" id="company" aria-describedby="companyHelp" value="{{ Request::old('company') ?? $response['data']['cliente']['empresa'] }}">
                        
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="rfc_company">@lang('auth.rfc_company')</label>
                        <input type="text" class="form-control" name="rfc_company" id="rfc_company" aria-describedby="rfc_companyHelp" value="{{ Request::old('rfc_company') ?? $response['data']['cliente']['rfc_company'] }}">
                        
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn-edit">@lang('auth.send')</button>
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


@endsection

@section('page-scripts')

<script type="text/javascript">
    $(".pais_select").select2();
    $(document).ready(function(){
        $(".btn-edit").click(function(){
            console.log('fui presionado');
            $(".btn-edit").css('display','none');
            $(".spinner").css('display','initial');
        });
        
    });
</script>
    
@endsection
