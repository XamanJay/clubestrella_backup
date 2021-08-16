@extends('layouts.dashboard')

@section('page-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content')
<div class="container box-edit">
    <div class="row">
        <div class="col-12">
            <ul class="breadcrumbCustom">
                <li><a href="{{ route('dashboard',App::getLocale()) }}" class="purple-T"><i class="fas fa-home"></i>Dashboard</a></li>
                <li>-></li>
                <li>Editando Cliente</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-pencil-alt edit-icon"></i>{{$user->nombre }}</h2>
    @if($errors->any())
        <div class="alert alert-danger " >
            <ul style="list-style: none;">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success " >
            <ul style="list-style: none;">
                @foreach(session('success') as $string)
                    <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$string}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger " >
            <ul style="list-style: none;">
                @foreach(session('error') as $string)
                    <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$string}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('update-cliente', ['locale' => App::getLocale(), 'id' => $user->id]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="nombre">Nombre(s) <span>*</span></label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="{{ Request::old('nombre') ?? $user->nombre }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="apellidos">Apellidos<span>*</span></label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ Request::old('apellidos') ??  $user->apellidos }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="email">Email<span>*</span></label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ Request::old('email') ?? $user->email }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="celular">Celular<span>*</span></label>
                    <input type="numeric" class="form-control" name="celular" id="celular" value="{{ Request::old('celular') ?? $user->cliente->celular }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="pais">Pais<span>*</span></label>
                    <select name="pais" id="pais" class="form-control pais_select">
                        @if (Request::old('pais'))
                            @foreach ($paises as $pais)
                                @if ($pais->nombre == Request::old('pais'))
                                    <option value="{{ $pais->nombre }}" selected>{{ $pais->nombre }}</option>
                                    @else 
                                    <option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>   
                                @endif
                            @endforeach
                        @else

                            <option value="{{ $user->cliente->pais}}" selected>{{ $user->cliente->pais }}</option>
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
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" class="form-control" name="estado" id="estado" value="{{ Request::old('estado') ?? $user->cliente->estado }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" class="form-control" name="ciudad" id="ciudad" value="{{ Request::old('ciudad') ?? $user->cliente->ciudad }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" value="{{ Request::old('direccion') ?? $user->cliente->direccion }}">
                </div>
            </div>         
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="cp">CP</label>
                    <input type="text" class="form-control" name="cp" id="cp" value="{{ Request::old('cp') ?? $user->cliente->cp }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="empresa">Empresa</label>
                    <input type="text" class="form-control" name="empresa" id="empresa" value="{{ Request::old('empresa') ?? $user->cliente->empresa }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="rfc_company">RFC Compañia</label>
                    <input type="text" class="form-control" name="rfc_company" id="rfc_company" value="{{ Request::old('rfc_company') ?? $user->cliente->rfc_company }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-edit">Editar</button>
                    <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                    <a href="{{ route('dashboard',App::getLocale()) }}" class="btn btn-danger">Regresar</a>
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
                $(".btn-edit").css('display','none');
                $(".btn-danger").css('display','none');
                $(".spinner").css('display','block');
            });    
        });
    </script>
@endsection