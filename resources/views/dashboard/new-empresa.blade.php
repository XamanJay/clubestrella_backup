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
                <li>Cuenta Comercial</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-pencil-alt edit-icon"></i>Nueva Cuenta Comercial</h2>
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
                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{ session('success') }}</li>
            </ul>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger " >
            <ul style="list-style: none;">
                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{ session('error') }}</li>
            </ul>
        </div>
    @endif
    <form action="{{ route('store.empresa',App::getLocale()) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="numero_cuenta">Numero Cuenta<span>*</span></label>
                    <input type="text" class="form-control" name="numero_cuenta" id="numero_cuenta" value="{{ Request::old('numero_cuenta') ?? "" }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="nombre_cuenta">Nombre Cuenta<span>*</span></label>
                    <input type="text" class="form-control" name="nombre_cuenta" id="nombre_cuenta" value="{{ Request::old('nombre_cuenta') ?? "" }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="company_rfc">RFC Compañia</label>
                    <input type="text" class="form-control" name="company_rfc" id="company_rfc" value="{{ Request::old('company_rfc') ?? "" }}">
                </div>
            </div>  
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="razon_social">Razon Social</label>
                    <input type="text" class="form-control" name="razon_social" id="razon_social" value="{{ Request::old('razon_social') ?? "" }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="ciudad">Ciudad<span>*</span></label>
                    <input type="text" class="form-control" name="ciudad" id="ciudad" value="{{ Request::old('ciudad') ?? "" }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="limite_credito">Limite Credito<span>*</span></label>
                    <input type="text" class="form-control" name="limite_credito" id="limite_credito" value="{{ Request::old('limite_credito') ?? "" }}">
                </div>
            </div>    
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="ar">A/R</label>
                    <input type="text" class="form-control" name="ar" id="ar" value="{{ Request::old('ar') ?? "" }}">
                </div>
            </div>
            
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="credito_habitacion">Credito Habitación</label>
                    <select name="credito_habitacion" id="credito_habitacion" class="form-control">
                        @if (Request::old('credito_habitacion'))
                            @if (Request::old('credito_habitacion') == 1)
                                <option value=1 selected>Si</option>
                                <option value=0>No</option>
                            @else 
                                <option value=0 selected>No</option>
                                <option value=1>Si</option>
                            @endif
                        @else
                            <option value=0>No</option>
                            <option value=1>Si</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="credito_alimentos">Credito Alimentos</label>
                    <select name="credito_alimentos" id="credito_alimentos" class="form-control">
                        @if (Request::old('credito_alimentos'))
                            @if (Request::old('credito_alimentos') == 1)
                                <option value=1 selected>Si</option>
                                <option value=0>No</option>
                            @else 
                                <option value=0 selected>No</option>
                                <option value=1>Si</option>
                            @endif
                        @else
                            <option value=0>No</option>
                            <option value=1>Si</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-edit">Crear</button>
                    <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                    <a href="{{ route('cuenta.comercial',App::getLocale()) }}" class="btn btn-danger">Regresar</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('page-scripts')
    <script type="text/javascript"> 
        $(document).ready(function(){
            $(".btn-edit").click(function(){
                $(".btn-edit").css('display','none');
                $(".btn-danger").css('display','none');
                $(".spinner").css('display','block');
            });    
        });
    </script>
@endsection