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
                <li>Carga Puntos</li>
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
    <form action="{{ route('store.puntos',['locale' => App::getLocale(),'id' => $user->id]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="factura_folio">Factura Folio<span>*</span></label>
                    <input type="text" class="form-control" name="factura_folio" id="factura_folio" value="{{ Request::old('factura_folio') ?? "" }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="rfc">RFC<span>*</span></label>
                    <input type="text" class="form-control" name="rfc" id="rfc" value="{{ Request::old('rfc') ?? "" }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="puntos">Puntos<span>*</span></label>
                    <input type="numeric" class="form-control" name="puntos" id="puntos" value="{{ Request::old('puntos') ?? "" }}">
                </div>
            </div>
            <div class="col-12 col-sm-12">
                <div class="form-group">
                    <label for="comentarios">Comentarios</label>
                    <textarea name="comentarios" id="comentarios" cols="30" rows="6" class="form-control" style="resize: none;">{{ Request::old('comentarios') ?? "" }}</textarea>
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