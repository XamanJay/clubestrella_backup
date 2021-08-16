@slot('header')
    @component('mail::header', ['url' => config('app.url')])
    Canje Club Estrella
    @endcomponent
@endslot
@component('mail::message')
<div style="margin-bottom:20px;">
    <h1 style="margin-bottom: 20px;color:#D7A662;text-align:center;">ID de Seguimiento: {{ $canje->id }}</h1>
    <div style="text-align:center;">
        <p style="text-align: center;margin-bottom:4px;color:white;">En Club Estrella te queremos bien,</p>
        <p style="text-align: center;color:white;">por eso te recordamos usar cubrebocas en todo momento.</p>
        <img src="http://www.clubestrella.mx/img/items/mascarilla.png" alt="Cubrebocas" style="width:200px;display:block;margin:0px auto;margin-bottom:20px;">
    </div>
    <h1 style="text-align:center;color:#D7A662;font-family:sans-serif;margin-bottom:30px;margin-top:30px;">Gracias por Canjear con Nosotros</h1>
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
    <img src="{{ $path }}" alt="{{ $reward->nombre }}" style="display: block;margin:0px auto;margin-bottom:50px;">
    <p style="color:white;margin-bottom:4px;">Premio: {{ $reward->nombre}} </p>
    @if($room)
        <p style="color:white;margin-bottom:4px;">CheckIn: {{ ($canje->fecha_inicio == NULL) ? 'No aplica' : $canje->fecha_inicio }}</p>
        <p style="color:white;margin-bottom:4px;">CheckOut: {{ ($canje->fecha_salida == NULL) ? 'No aplica' : $canje->fecha_salida }}</p>
        <p style="color:white;margin-bottom:4px;">Noches: {{ ($canje->noches == NULL) ? 'No aplica' : $canje->noches }}</p>
        <p style="color:white;margin-bottom:4px;">Cuartos: {{ ($canje->cuartos == NULL) ? 'No aplica' : $canje->cuartos }}</p>   
    @endif
    <p style="color:white;margin-bottom:4px;">Puntos: {{ number_format($canje->puntos) }} pts</p>
    <p style="color:white;margin-bottom:4px;">Cantidad: {{ $canje->cantidad }} pza(s)</p>
    <p style="color:white;margin-bottom:20px;">Detalles: {{ $canje->comentarios }}</p>

</div>
<p style="color:white;margin-bottom:0px;">Gracias,<br>
{{ config('app.name') }}</p>
@endcomponent