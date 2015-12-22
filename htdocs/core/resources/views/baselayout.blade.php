<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="TTF-Stühlingen">

        <title>Hallenbelegungen</title>

        <!-- Custom CSS -->
        {!! Html::style('/dist/css/main.out.min.css') !!}

        <!-- Custom Fonts -->
        {!! Html::style('/dist/fonts/font-awesome/css/font-awesome.min.css') !!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="page-top" class="index">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" tabindex="2" class="navbar-toggle" data-toggle="collapse" data-target="#mobile-menu">
                        <div class="hamburger-menu">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </div>
                    </button>
                    <a class="navbar-brand" href="{{ route('index') }}" tabindex="1">Hallenbelegungen</a>
                </div>

                @if (isset($showNav))
                    <div class="collapse navbar-collapse" id="mobile-menu">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="page-scroll">
                                <a href="#hallen">Hallen</a>
                            </li>
                            <li class="page-scroll">
                                <a href="#infos">Über</a>
                            </li>
                            <li class="page-scroll">
                                <a href="#kontakt">Kontakt</a>
                            </li>
                            @if (Auth::check())
                                @include('partials._nav_management')
                            @endif
                        </ul>
                    </div>
                @elseif (Auth::check())
                    <div class="collapse navbar-collapse" id="mobile-menu">
                        <ul class="nav navbar-nav navbar-right">
                            @include('partials._nav_management')
                        </ul>
                    </div>
                @endif

                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="text-center">
            <div class="footer-above">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-md-4">
                            <h3>Wo sind wir</h3>
                            <p>Bahnhofstraße 10<br>79780 Stühlingen<br>Deutschland</p>
                        </div>
                        <div class="footer-col col-md-4">
                            <h3>Wir im Internet</h3>
                            <ul class="list-inline">
                                <li>
                                    <a href="http://www.ttf-stuehlingen.de/" target="_blank" title="Neues Fenster: Unsere Homepage" class="btn-social btn-outline"><i class="fa fa-fw fa-home"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/TTFStuehlingen/" target="_blank" title="Neues Fenster: Unsere Facebook Seite" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-col col-md-4">
                            <h3>Verwaltung</h3>
                            @if (Auth::check())
                                <a href="{{ route('logout') }}">Abmelden</a>
                            @else
                                <a href="{{ route('login') }}">Anmelden</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-below">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            Copyright &copy; TTF-Stühlingen 2015
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
        <div class="scroll-top page-scroll visible-xs visible-sm">
            <a class="btn btn-primary" href="#page-top">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>

        <!-- Custom JavaScript -->
        <!-- {!! Html::script('/dist/js/main.min.js') !!} -->
        {!! Html::script('/dist/js/main.js') !!}

    </body>
</html>
