@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card cardRegister">
                <div class="card-header center-text"><i class="fas fa-qrcode" style="margin-right: 10px;"></i>Escanea tu tarjeta</div>
                <div class="card-body">
                    <form method="POST" id="qr-session">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="qr-card" type="text" class="form-control @error('qr_card') is-invalid @enderror" name="qr_card" autofocus>

                                @error('qr_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="spinner">
                                    <div class="rect1"></div>
                                    <div class="rect2"></div>
                                    <div class="rect3"></div>
                                    <div class="rect4"></div>
                                    <div class="rect5"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var url = "{{ url('/') }}";
        $('#qr-card').on('keyup', function () {
            values = $(this).val();
            var limiter = values.substr(values.length - 1);
            if(limiter == "_"){
                $('.spinner').css('display','block');
                $.ajax({
                    url: '/es/qr-login',
                    data: $('#qr-session').serialize(),
                    type: 'POST',
                    success: function(response){

                        $('.spinner').css('display','none');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').removeClass('alert-success');
                        if(response.code == 200)
                        {
                            window.location.assign(url+"/es/home");
                            $('.alert').addClass('alert-success');
                            $('.alert').html('');
                            $('.alert').append('<i class="far fa-check-circle" style="margin-right:10px;"></i>'+response.message);
                            $("#factura").val('');
                        }else{
                            $('.alert').addClass('alert-danger');
                            $('.alert').html('');
                            $('.alert').append('<i class="fas fa-exclamation-triangle" style="margin-right:10px;"></i>'+response.message);
                            $("#factura").val('');
                        }
                        
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
