<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notify Recepcion</title>
</head>
<body>
<div style="margin-bottom:20px;background-color:white;padding:30px;color:black;font-family:sans-serif;">
    <h1 style="text-align:center;color:#7C1653;font-family:sans-serif;margin-bottom:30px;margin-top:30px;">Canje Realizado por {{ $user->nombre." ".$user->apellidos }}</h1>
    <h2 style="margin-bottom: 20px;color:#7C1653;text-align:center;">ID de Seguimiento: {{ $canje->id }}</h2>

    <p>Premio: {{ $reward->nombre}}</p>
    <p>Puntos: {{ number_format($canje->puntos) }} pts</p>
    <p>Cantidad: {{ $canje->cantidad }} pza(s)</p>
    <p>Detalles: {{ $canje->comentarios }}</p>
    @if($room)
        <p>CheckIn: {{ ($canje->fecha_inicio == NULL) ? 'No aplica' : $canje->fecha_inicio }}</p>
        <p>CheckOut: {{ ($canje->fecha_salida == NULL) ? 'No aplica' : $canje->fecha_salida }}</p>
        <p>Noches: {{ ($canje->noches == NULL) ? 'No aplica' : $canje->noches }}</p>
        <p>Cuartos: {{ ($canje->cuartos == NULL) ? 'No aplica' : $canje->cuartos }}</p>
    @endif
    
    
</div>
</body>
</html>