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
                <li>Puntos Dobles</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-pencil-alt edit-icon"></i>Habilitar Puntos Dobles</h2>
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
                @foreach(session('error') as $string)
                    <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$string}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('update.puntos.dobles',App::getLocale()) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-4 offset-sm-4">
                <div class="form-group">
                    <label for="nombre">Estatus <span>*</span></label>
                    <select name="puntos_dobles" id="puntos_dobles" class="form-control">  
                        @if ($puntos_dobles->puntos_dobles)
                            <option value="1" selected>Habilitado</option>
                            <option value="0">Deshabilitar</option>
                        @else
                        <option value="0" selected>Deshabilitado</option>
                            <option value="1" >Habilitar</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-4 offset-sm-4">
                <div class="form-group">
                    <button type="submit" class="btn btn-edit">Actualizar Puntos Dobles</button>
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
                console.log('fui presionado');
                $(".btn-edit").css('display','none');
                $(".spinner").css('display','block');
            });
            
        });

    </script>
@endsection