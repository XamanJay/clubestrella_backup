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
                <li>Canje Premios</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-pencil-alt edit-icon"></i>Nuevo Canje para {{ $user->nombre }}</h2>
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
    <form action="{{ route('store.premio',['locale' => App::getLocale(),'id' => $user->id]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-4 offset-sm-4">
                <div class="form-group">
                    <label for="factura_folio">Premio<span>*</span></label>
                    <select name="premio" id="premio" class="form-control premio_select">
                        <option value="">-- Escoge el Premio --</option>
                        @foreach ($premios as $premio)
                            <option value="{{ $premio->id }}">{{ $premio->nombre." - ".$premio->puntos.' pts' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="box-dinamic row" style="margin: 0px;padding:0px;width:100%;margin-bottom:30px;">
                <div class="col-12 col-sm-6">
                    <label for="">Cantidad</label>
                    <input type="numeric" class="form-control" name="product[qty][]">
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
                    <input type="hidden" name="product[id][]" id="product_id">
                    <button type="submit" class="btn btn-edit">Crear</button>
                    <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                    <a href="{{ route('detalles-puntos',['locale' => App::getLocale(),'id' => $user->id]) }}" class="btn btn-danger">Cancelar</a>
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
        $(".premio_select").select2();
        $('.premio_select').on("select2:select", function (e) {
            console.log($('.premio_select').select2());
            if($('.premio_select').select2().val() == 36){
                $('.box-dinamic').html('');
                $('.box-dinamic').append('<div class="col-12 col-sm-6" style="margin-bottom:15px;">'+
                    '<label for="startDate">CheckIn</label>'+
                    '<input class="form-control" type="text" name="startDate[]" id="startDate" data-dd-format="d-m-Y" placeholder="dd/mm/YY">'+
                '</div>'+
                '<div class="col-12 col-sm-6" style="margin-bottom:15px;">'+
                    '<label for="endDate">CheckOut</label>'+
                    '<input class="form-control" type="text" name="endDate[]" id="endDate" data-dd-format="d-m-Y" placeholder="dd/mm/YY">'+
                '</div>'+
                '<div class="col-12 col-sm-6">'+
                    '<label for="cuartos">Cuartos</label>'+
                    '<input class="form-control" type="text" name="cuartos" value="1" readonly>'+
                '</div>'+
                '<div class="col-12 col-sm-6">'+
                    '<label for="product">Noches</label>'+
                    '<input type="numeric" class="form-control" name="product[qty][]" id="product_qty">'+
                '</div>');
                $('#startDate').dateDropper();
                $('#endDate').dateDropper();
                $('#product_id').val($('.premio_select').select2().val());

            }else{
                console.log('here');
                $('.box-dinamic').html('');
                $('.box-dinamic').append('<div class="col-12 col-sm-6">'+
                    '<label for="product">Cantidad</label>'+
                    '<input type="numeric" class="form-control" name="product[qty][]" value ="1">'+
                '</div>');
                $('#product_id').val($('.premio_select').select2().val());
            }
        });

        $('#product_id').val($('.premio_select').select2().val());

    </script>
@endsection