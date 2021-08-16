@slot('header')
    @component('mail::header', ['url' => config('app.url')])
    Registo Club Estrella
    @endcomponent
@endslot
@component('mail::message')

<div style="margin-bottom:20px;">
    <img src="{{ config('app.url') }}/img/mail/mail_welcome.png" alt="Club Estrella Bienvenido" style="width:180px;display:block;margin:0px auto;margin-top:15px;margin-bottom:30px;">
    <h1 style="color:#D7A662;text-align:center;font-size:25px;">Numero de Socio: {{ $user->cliente->numero_socio}}</h1>
    <p style="text-align:center;color:white;font-weight:400;padding:5px;">El programa de recompensas para el viajero frecuente, creado para reconocer su preferencia mediante beneficios exclusivos.</p>
    <a href="{{ config('app.url') }}" target="_blank" style="background-color: white;
    display:block;
    margin:0px auto;
    color:#7C1653;
    width: 200px;
    text-align: center;
    padding: 8px;
    margin-top: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-decoration: none;">¡Ir a Club Estrella!</a>
    <img src="{{ config('app.url') }}/img/mail/mail_oktrip.png" alt="Oktrip.mx" style="margin-top:30px;margin-bottom:15px;display:block;width:100%;">
    <p style="margin-bottom:30px;text-align:center;color:white;">Oktrip Agencia de Viajes</p>
    <img src="{{ config('app.url') }}/img/mail/mail_adhara.png" alt="Adhara Cancun" style="margin-top:30px;margin-bottom:15px;display:block;width:100%;">
    <p style="margin-bottom:30px;text-align:center;color:white;">Hotel Adhara Cancún</p>
    <img src="{{ config('app.url') }}/img/mail/mail_eventos.png" alt="Eventos Adhara" style="margin-top:30px;margin-bottom:15px;display:block;width:100%;">
    <p style="margin-bottom:30px;text-align:center;color:white;">Recompensas Club Estrella</p>
    <img src="{{ config('app.url') }}/img/mail/mail_clubestrella.png" alt="Club Estrella" style="margin-top:30px;display:block;width:100%;">
</div>


<p style="color:white;marging-bottom:0px;">Gracias por registrarte en,<br>
{{ config('app.name') }}</p>
@endcomponent
