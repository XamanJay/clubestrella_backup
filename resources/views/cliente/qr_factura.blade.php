@extends('layouts.app')

@section('page-styles')
    <link href="{{ asset('css/qr.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="alert" role="alert">
            {{ session('success') }}
        </div>
        <h1 class="gold-title cinzel-font"><i class="fas fa-qrcode"></i>Escanea tu factura</h1>
        <form action="" id="postFactura">
            @csrf
            <input type="password" name="factura" id="factura" class="form-control" autofocus>
            <div class="spinner">
                <div class="rect1 contact-s"></div>
                <div class="rect2 contact-s"></div>
                <div class="rect3 contact-s"></div>
                <div class="rect4 contact-s"></div>
                <div class="rect5 contact-s"></div>
            </div>
            
        </form>
    </div>


@endsection

@section('page-scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $('#factura').on('keyup', function () {
            values = $(this).val();
            var limiter = values.substr(values.length - 2);
            if(limiter == "¿¿"){
                $('.spinner').css('display','block');
                $.ajax({
                    url: '/es/qr_factura',
                    data: $('#postFactura').serialize(),
                    type: 'POST',
                    success: function(response){
                        $('.spinner').css('display','none');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-success');
                        if(response.code == 200)
                        {
                            $('.alert').addClass('alert-success');
                            $('.alert').html('');
                            $('.alert').append('<i class="far fa-check-circle" style="margin-right:10px;"></i>'+response.message);
                        }else{
                            $('.alert').addClass('alert-danger');
                            $('.alert').html('');
                            $('.alert').append('<i class="fas fa-exclamation-triangle" style="margin-right:10px;"></i>'+response.message);
                        }
                        $("#factura").val('');
                    },
                    error: function(error){
                        $('.spinner').css('display','none');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert').html('');
                        $('.alert').append('<i class="fas fa-exclamation-triangle" style="margin-right:10px;"></i> Error inesperado, intente de nuevo');
                        $("#factura").val('');
                    }
                });
            }
        });
        
    });
</script>
    
@endsection
