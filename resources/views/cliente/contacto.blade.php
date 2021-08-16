@extends('layouts.app')

@section('content')
<div class="container">

    <form method="post" action="{{ route('post.contacto',App::getLocale()) }}" id="contactForm">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="text-white"><h2>Contáctanos</h2></div>
                @if($errors->any())
                    <div class="alert alert-danger " >
                        <ul style="list-style: none;">
                            @foreach($errors->all() as $error)
                                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif 
                <!-- Success message -->
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                <div class="form-group">
                    <label for="name" class="text-white">Nombre</label>
                     <input id="name" name="name" type="text" size="25"  class="form-control" >
                </div>
                <div class="form-group">
                    <label for="email" class="text-white">E-mail </label>
                    <input id="email" name="email" type="email" size="25" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="issue" class="text-white">Asunto</label>
                    <input id="issue" name="issue" type="text" size="25" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="message" class="text-white">Mensaje </label>
                    <textarea id="message" name="message" rows="4" class="form-control" style="resize: none;"></textarea>
                </div>
                <!--div class="recaptcha">
                    <div> recaptcha </div>
                </div-->
                <div class="form-group center-align">
                    <button type="submit" class="btn btn-light btn-edit" > @lang('home.enter') </button>
                    <div class="spinner">
                        <div class="rect1 contact-s"></div>
                        <div class="rect2 contact-s"></div>
                        <div class="rect3 contact-s"></div>
                        <div class="rect4 contact-s"></div>
                        <div class="rect5 contact-s"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 txt-ubicacion">
                 <div class="form-group">
                    <div class="text-white">
                        <h2>Ubicación:</h2>
                    </div>
                    <div id=map>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d930.1509555479493!2d-86.8242173563032!3d21.16815910657098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2smx!4v1604079321094!5m2!1ses-419!2smx" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                 </div>
                <div class="form-group text-white">
                    <div class="col s12 m12">
                        <p>
                            Av. Carlos Nader 1,2,3 SM. 1, Mz. 2,<br>
                            Cancún, Quintana Roo, México.<br>
                            CP. 77500<br><br>
                            Llamando sin costo al: 01 800 711-15-31<br>
                            (México)<br>						
                            Teléfono: +52 (998) 881 65 00 <br>
                            clubestrella@gphoteles.com
                        </p>
                    </div>
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
            console.log('fui presionado');
            $(".btn-edit").css('display','none');
            $(".spinner").css('display','initial');
        });
        
    });
</script>
    
@endsection