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
                <li>Editando Premio</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-pencil-alt edit-icon"></i>Editando {{$regalo->nombre }}</h2>
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
    <form action="{{ route('update.premio.club', ['locale' => App::getLocale(), 'id' => $regalo->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="nombre">Nombre<span>*</span></label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="{{ Request::old('nombre') ?? $regalo->nombre }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="puntos">Puntos<span>*</span></label>
                    <input type="numeric" class="form-control" name="puntos" id="puntos" value="{{ Request::old('puntos') ??  $regalo->puntos }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="tag">Etiquetas<span>*</span></label>
                    <select name="tag[]" id="tag[]" multiple class="tags form-control">
                        @php
                            $tags = json_decode($regalo->tag);
                        @endphp
                        @foreach ($tags as $tag)
                            @foreach ($tags_custom as $taggy)
                                
                                @if ($tag == $taggy)
                                    <option value="{{ $taggy }}" selected>{{ $taggy }}</option>
                                @else
                                    <option value="{{ $taggy }}">{{ $taggy }}</option>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="celular">Categoria<span>*</span></label>
                    <select name="categoria_id" id="categoria" class="form-control">
                        @foreach ($categorias as $categoria)
                            @if ($categoria->id == $regalo->categoria_id)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @else 
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="puntos">Descripcion<span>*</span></label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" style="resize: none;">{{ $regalo->descripcion}}</textarea>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-edit">Editar</button>
                    <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                    <a href="{{ route('premios.club',App::getLocale()) }}" class="btn btn-danger">Regresar</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('page-scripts')
    
    <script type="text/javascript"> 
        $(".tags").select2();
        $(document).ready(function(){
            $(".btn-edit").click(function(){
                $(".btn-edit").css('display','none');
                $(".btn-danger").css('display','none');
                $(".spinner").css('display','block');
            });    
        });
    </script>
@endsection