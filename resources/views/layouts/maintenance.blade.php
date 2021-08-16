<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ClubEstrella') }}</title>

    <!-- Scripts -->
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <!--script src="{{ asset('js/app.js') }}" defer></script-->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('page-styles')
</head>
<body>
    <div id="app">
        <main class="py-4">    
            @yield('content')
        </main>
    </div>

    <div class="footer">
        <div class="container">
            <ul class="foot-terms d-flex justify-content-center">
                <li>TÉRMINOS Y CONDICIONES</li>
                <li class="no-mobile">&nbsp;&nbsp;/&nbsp;&nbsp;</li>
                <li>POLITICA DE PRIVACIDAD</li>
            </ul>
            <ul class="foot-rights d-flex justify-content-center margin-end-60">
                <li>TODOS LOS DERECHOS RESERVADOS</li>
                <li class="no-mobile">&nbsp;&nbsp;/&nbsp;&nbsp;</li>
                <li>CLUBESTRELLA 2020</li>
            </ul>
        </div>
    </div>
    @yield('page-scripts')
</body>
</html>
