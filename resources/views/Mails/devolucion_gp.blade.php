<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notify Devolucion</title>
</head>
<body>
<div style="margin-bottom:20px;background-color:white;padding:30px;color:black;font-family:sans-serif;">

    <h1 style="text-align:center;color:#7C1653;font-family:sans-serif;margin-bottom:60px;margin-top:30px;">Devolucion de Canje</h1>
    @if ($reservation != NULL)
        <h2 style="margin-bottom: 30px;color:#7C1653;text-align:center;">ID de Seguimiento: {{ $reservation->id }}</h2>
    @else 
        <h2 style="margin-bottom: 30px;color:#7C1653;text-align:center;">ID de Seguimiento: {{ $canje->id }}</h2>
    @endif

    <p>Cliente: {{ $user->nombre." ".$user->apellidos }}</p>
    <p>Premio: {{ $reward->nombre}}</p>
    <p>Puntos: {{ number_format($canje->puntos) }} pts</p>
  
</div>
</body>
</html>