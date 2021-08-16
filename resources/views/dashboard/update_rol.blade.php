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
                <li>Editando Rol</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-pencil-alt edit-icon"></i>Editando Rol de {{$user->nombre }}</h2>
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
    <form action="{{ route('update.rol', ['locale' => App::getLocale(), 'id' => $user->id]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-4 offset-sm-4">
                <div class="form-group">
                    <label for="nombre">Rol <span>*</span></label>
                    <select name="rol_id" id="rol_id" class="form-control">
                        @foreach ($roles as $rol)
                            
                            @if ($rol->id == $user->rol_id)
                                <option value="{{ $rol->id}}" selected>{{$rol->nombre}}</option>
                            @else
                                <option value="{{ $rol->id}}">{{$rol->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-4 offset-sm-4">
                <div class="form-group">
                    <button type="submit" class="btn btn-edit">Editar Rol</button>
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