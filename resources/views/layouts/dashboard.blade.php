<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashboard ClubEstrella') }}</title>

    <!-- Scripts -->
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    @yield('page-styles')
</head>
<body>
    <div id="app" class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('img/logos/clubestrella_gold.png') }}" alt="Club Estrella">
            </div>

            <ul class="list-unstyled components">
                <p>Admin Club Estrella</p>
                <li>
                    <a href="{{ route('dashboard',App::getLocale()) }}">
                        <i class="fas fa-user"></i> Clientes
                    </a>
                </li>
                <li>
                    <a href="{{ route('cuenta.comercial',App::getLocale()) }}">
                        <i class="fas fa-address-card"></i> Cuentas Comerciales
                    </a>
                </li>
                @if (Auth::user()->rol->nombre == "Supervisor" || Auth::user()->rol->nombre == "Administrador")
                    <li>
                        <a href="{{ route('temporadas.comerciales',App::getLocale()) }}">
                            <i class="fas fa-calendar-alt"></i> Temporadas Comerciales (App)   
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stop.sale.comercial',App::getLocale()) }}">
                            <i class="fas fa-hand-paper"></i> StopSale TarifaComercial
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stop.sale.clubestrella',App::getLocale()) }}">
                            <i class="fas fa-hand-paper"></i> StopSale ClubEstrella
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('puntos.dobles',App::getLocale()) }}">
                            <i class="fas fa-percent"></i> Puntos Dobles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('premios.club',App::getLocale()) }}">
                            <i class="fas fa-gift"></i> Premios Club Estrella
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tarjetas.club',App::getLocale()) }}">
                            <i class="fas fa-id-card"></i> Tarjetas ClubEstrella
                        </a>
                    </li>
                @endif
            </ul>

            <!--ul class="list-unstyled CTAs">
                <li>
                    <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
                </li>
                <li>
                    <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                </li>
            </ul-->
        </nav>
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light" id="toogle-nav">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Menú</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <img src="{{ asset('img/avatar/ninja.png') }}" alt="Avatar Club Estrella" style="width: 50px;">
                            </li>
                            <li class="nav-item">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 7px;">
                                    {{ Auth::user()->nombre }} <span class="caret"></span>
                                </a>

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
                        </ul>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
    @yield('page-scripts')
</body>
</html>
