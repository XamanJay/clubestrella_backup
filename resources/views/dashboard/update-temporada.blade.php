@extends('layouts.dashboard')

@section('page-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/datedropper.pro.min.js') }}"></script>
@endsection

@section('content')
<div class="container box-edit">
    <div class="row">
        <div class="col-12">
            <ul class="breadcrumbCustom">
                <li><a href="{{ route('dashboard',App::getLocale()) }}" class="purple-T"><i class="fas fa-home"></i>Dashboard</a></li>
                <li>-></li>
                <li>Temporada Comercial</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-calendar-alt edit-icon"></i>Nueva Temporada Comercial</h2>
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
    <form action="{{ route('update.temporada',['locale' => App::getLocale(),'id' => $temporada->id]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="numero_cuenta">Fecha Inicio<span>*</span></label>
                    <input class="datedropper-init form-control" type="text" name="startDate" data-dd-format="d-m-Y" placeholder="dd/mm/YY" value="{{ Request::old('startDate') ?? $temporada->fecha_inicio }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="nombre_cuenta">Fecha Termina<span>*</span></label>
                    <input class="datedropper-init form-control" type="text" name="endDate" data-dd-format="d-m-Y" placeholder="dd/mm/YY" value="{{ Request::old('endDate') ?? $temporada->fecha_termino }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="tarifa_base">Tarifa Base<span>*</span></label>
                    <input type="text" class="form-control" name="tarifa_base" id="tarifa_base" value="{{ Request::old('tarifa_base') ?? $temporada->tarifa_base }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="tarifa_pax">Tarifa Pax<span>*</span></label>
                    <input type="text" class="form-control" name="tarifa_pax" id="tarifa_pax" value="{{ Request::old('tarifa_pax') ?? $temporada->tarifa_pax }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="tarifa_alimentos">Tarifa Alimentos</label>
                    <input type="text" class="form-control" name="tarifa_alimentos" id="tarifa_alimentos" value="{{ Request::old('tarifa_alimentos') ?? $temporada->tarifa_alimentos }}">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="tarifa_upgrade_habitacion">Tarifa Upgrade Habitación</label>
                    <input type="text" class="form-control" name="tarifa_upgrade_habitacion" id="tarifa_upgrade_habitacion" value="{{ Request::old('tarifa_upgrade_habitacion') ?? $temporada->tarifa_upgrade_habitacion }}">
                </div>
            </div>        
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="hotel_id">Hotel</label>
                    <select name="hotel_id" id="hotel_id" class="form-control">
                        @foreach ($hoteles as $hotel)            
                            @if (Request::old('hotel_id'))
                                <option value="{{ $hotel->id }}" selected>{{ $hotel->nombre }}</option>
                            @else
                                @if ($temporada->hotel_id)
                                    <option value="{{ $hotel->id }}" selected>{{ $hotel->nombre }}</option>    
                                @else
                                    <option value="{{ $hotel->id }}">{{ $hotel->nombre }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-edit">Actualizar</button>
                    <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                    <a href="{{ route('temporadas.comerciales',App::getLocale()) }}" class="btn btn-danger">Regresar</a>
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