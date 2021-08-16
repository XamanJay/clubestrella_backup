@slot('header')
    @component('mail::header', ['url' => config('app.url')])
    Devolución Club Estrella
    @endcomponent
@endslot
@component('mail::message')
<div style="margin-bottom:20px;">
    <div style="text-align:center;">
        <p style="text-align: center;margin-bottom:4px;color:white;">En Club Estrella te queremos bien,</p>
        <p style="text-align: center;color:white;">por eso te recordamos usar cubrebocas en todo momento.</p>
        <img src="http://www.clubestrella.mx/img/items/mascarilla.png" alt="Cubrebocas" style="width:200px;display:block;margin:0px auto;margin-bottom:20px;">
    </div>
    <h1 style="text-align:center;color:#D7A662;font-family:sans-serif;margin-bottom:60px;margin-top:30px;">Devolución de Canje Club Estrella</h1>
    @if ($reservation != NULL)
        <h2 style="text-align:center;color:#D7A662;font-family:sans-serif;margin-bottom:30px;margin-top:30px;">Id de Seguimiento {{ $reservation->id }}</h2>
    @else 
        <h2 style="text-align:center;color:#D7A662;font-family:sans-serif;margin-bottom:30px;margin-top:30px;">Id de Seguimiento {{ $canje->id }}</h2>
    @endif
    @php
        $path = "";
        if($reward->custom == 1){
            $url_img = json_decode($reward->imgs);
            $path = config('app.url').'/'.$url_img[0];
        }
        if($reward->custom == 2){
            $url_img = json_decode($reward->imgs);
            $path = config('app.url').Storage::url($url_img[0]);
        }
    @endphp
    <img src="{{ $path }}" alt="{{ $reward->nombre }}" style="width:100px;display: block;margin:0px auto;margin-bottom:50px;">
    <p style="color:white;margin-bottom:8px;">Premio: {{ $reward->nombre}} </p>
    <p style="color:white;margin-bottom:4px;">Puntos Devueltos: {{ number_format($canje->puntos) }} pts</p>
</div>
<p style="color:white;margin-bottom:0px;">Gracias,<br>
{{ config('app.name') }}</p>
@endcomponent