@slot('header')
    @component('mail::header', ['url' => config('app.url')])
    Reset Password
    @endcomponent
@endslot
@component('mail::message')
<div style="margin-bottom:20px;">
    <img src="{{ config('app.url') }}/img/mail/mail_welcome.png" alt="Club Estrella Bienvenido" style="width:180px;display:block;margin:0px auto;margin-top:15px;margin-bottom:30px;">
    <h1 style="margin-bottom: 20px;color:#D7A662;text-align:center;">Hola {{ $user->nombre." ".$user->apellidos }} !!</h1>
    <div style="text-align:center;">
        <p style="text-align: center;margin-bottom:30px;color:white;">Has recibido este correo porque nosotros recibimos una peticion para resetear la password de tu cuenta,</p>
        <a href="{{ $url }}/{{$token}}?email={{$user->email}}" class="btn" style="background-color:white;padding:6px;border-radius:5px;color:#70124c;text-decoration:none;margin-bottom:30px;display:inline-block;">Resetear Password</a>
        <p style="text-align: center;margin-bottom:15px;color:white;">Este link para resetar la password expirará en 60 minutos</p>
        <p style="text-align: center;margin-bottom:80px;color:white;">Si tu no solicitaste el cambio de contraseña, ignora este correo</p>
    </div>
</div>
<p style="color:white;margin-bottom:0px;">Gracias,<br>
{{ config('app.name') }}</p>
@endcomponent