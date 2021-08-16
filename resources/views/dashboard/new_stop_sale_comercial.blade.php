@extends('layouts.dashboard')

@section('page-styles')
    <script src="{{ asset('js/datedropper.pro.min.js') }}"></script>
@endsection

@section('content')
<div class="container box-edit">
    <div class="row">
        <div class="col-12">
            <ul class="breadcrumbCustom">
                <li><a href="{{ route('dashboard',App::getLocale()) }}" class="purple-T"><i class="fas fa-home"></i>Dashboard</a></li>
                <li>-></li>
                <li>Stop Sale Cuenta Comercial</li>
            </ul>
        </div>
    </div>
    <h1 class="dashboard-h"><i class="fas fa-pencil-alt edit-icon"></i>Nuevo Stop Sale Cuenta Comercial</h1>
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
    <form action="{{ route('store.stop.sale.comercial',App::getLocale()) }}" method="POST" class="formStyle">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-4">
                <label for="startDate">@lang('checkout.startDate')</label>
                <input class="datedropper-init form-control" type="text" name="startDate" data-dd-format="d-m-Y" placeholder="dd/mm/YY" required>
            </div>
            <div class="col-12 col-sm-4">
                <label for="startDate">@lang('checkout.endDate')</label>
                <input class="datedropper-init form-control" type="text" name="endDate" data-dd-format="d-m-Y" placeholder="dd/mm/YY" required>
            </div> 
                                  
            <div class="col-12 col-sm-4">
                <div class="form-group">
                    <button type="submit" class="btn">Crear</button>
                    <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                    <a href="{{ route('stop.sale.comercial',App::getLocale()) }}" class="btn btn-danger">Regresar</a>
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