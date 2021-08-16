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
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <!--a class="navbar-brand" href="{{ url('/'. App::getLocale()) }}">
                    <img src="{{ asset('img/logos/clubestrella_70.png')}}" alt="Clubestrella" id="logo_club">
                </a-->
                <div class="dropdown mobile">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="select_lang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('img/lang/world.png') }}" alt="Idioma"> {{ Str::upper(App::getLocale()) }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="select_lang">
                        <a class="dropdown-item" href="{{ route(Route::currentRouteName(),'es')}}"> <img src="{{ asset('img/flags/mexico.png') }}" alt="español"> @lang('home.español')</a>
                        <a class="dropdown-item" href="{{ route(Route::currentRouteName(),'en')}}"> <img src="{{ asset('img/flags/usa.png') }}" alt="ingles"> @lang('home.ingles') </a>

                    </div>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <!--ul class="navbar-nav mr-auto">
                        <li></li>
                    </ul-->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav" id="navbarCustom">
                        <li class="nav-item d-flex align-items-center desktop-flex">
                            <a class="navbar-brand" href="{{ url('/'. App::getLocale()) }}">
                                <img src="{{ asset('img/logos/clubestrella_70.png')}}" alt="Clubestrella" id="logo_club">
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center desktop-flex">
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="select_lang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('img/lang/world.png') }}" alt="Idioma"> {{ Str::upper(App::getLocale()) }}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="select_lang">
                                    <a class="dropdown-item" href="{{ route(Route::currentRouteName(),'es')}}"> <img src="{{ asset('img/flags/mexico.png') }}" alt="español"> @lang('home.español')</a>
                                    <a class="dropdown-item" href="{{ route(Route::currentRouteName(),'en')}}"> <img src="{{ asset('img/flags/usa.png') }}" alt="ingles"> @lang('home.ingles') </a>

                                </div>
                            </div>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item d-flex align-items-center">
                                <img src="{{ asset('img/icons/user_login.png') }}" alt="Login"> @lang('home.Login')
                            </li>
                            <form action="{{ route('login',App::getLocale()) }}" method="POST" id="loginHome">
                                @csrf
                                <li class="nav-item d-flex align-items-center">
                                    <input type="email" name="email" placeholder="@lang('home.emailPlaceHolder')" class="form-control @if (session('error')) is-invalid @endif" >
                                </li>
                                <li class="nav-item d-flex align-items-center">
                                    <input type="password" name="password" placeholder="@lang('home.passwordPlaceHolder')" class='form-control @if (session('error')) is-invalid @endif' >
                                </li>
                                <li class="nav-item d-flex align-items-center">
                                    <button type="submit"> @lang('home.enter') </button>
                                </li>
                                @if (session('error'))
                                    <span class="failLog">
                                        <i class="fas fa-exclamation-triangle" style="margin-right: 10px;margin-left:5px;"></i> {{ session('error') }}
                                    </span>
                                @endif
                            </form>
                            <li class="nav-item d-flex align-items-center">
                                <a href="{{ route('qr.login',App::getLocale()) }}" id="qr-login"><i class="fas fa-qrcode"></i><br>QR</a>
                            </li>
                            <li class="nav-item d-flex align-items-center">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link linkForgot" href="{{ route('password.request',App::getLocale()) }}">
                                        @lang('home.passwordForgot')
                                    </a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item d-flex align-items-center">
                                <a href=" {{ route('home',App::getLocale() ) }}" class="nav-link">
                                    <img src="{{ asset('img/icons/home.png') }}" alt="Home Page"> @lang('client.homepage')
                                </a>
                            </li>
                            <li class="nav-item d-flex align-items-center">
                                <a href=" {{ route('estado_cuenta',App::getLocale() ) }}" class="nav-link">
                                    <img src="{{ asset('img/icons/cuenta.png') }}" alt="Estado de Cuenta"> @lang('client.estado_cuenta')
                                </a>
                            </li>
                            <li class="nav-item d-flex align-items-center">
                                <a href=" {{ route('perfil',App::getLocale() ) }}" class="nav-link">
                                    <img src="{{ asset('img/icons/user_login.png') }}" alt="Perfil"> @lang('client.perfil')
                                </a>
                            </li>
                            <li class="nav-item dropdown d-flex align-items-center">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nombre }} <span class="caret"></span>
                                </a>
                                <p id="points-client">@lang('home.puntos'): {{ number_format(Auth::user()->puntos->puntos_totales) }}</p>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout', App::getLocale()) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        @lang('home.logout')
                                    </a>

                                    <form id="logout-form" action="{{ route('logout', App::getLocale()) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                @guest
                    <li class="nav-item quick_menu" role="presentation">
                        <a class="" href="{{ route('contacto',App::getLocale()) }}">@lang('navbar.contacto')</a>
                    </li>      
                @else
                    <li class="nav-item quick_menu" role="presentation">
                        <a class=""  href="{{ route('qr.factura',App::getLocale()) }}" >@lang('navbar.qr')</a>
                    </li>
                    <li class="nav-item quick_menu" role="presentation">
                        <a class=""  href="{{ route('recompensas',App::getLocale()) }}" >@lang('navbar.recompensas')</a>
                    </li>
                    <li class="nav-item quick_menu" role="presentation">
                        <a class="" href="{{ route('contacto',App::getLocale()) }}">@lang('navbar.contacto')</a>
                    </li>   
                @endguest   
            </ul>
            
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
