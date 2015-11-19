<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="TTF-Stühlingen">

        <title>Hallenbelegungen</title>


        <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
        {!! Html::style('/css/vendor/bootstrap.min.css') !!}

        <!-- Custom CSS -->
        {!! Html::style('/css/dist/styles.min.css') !!}

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

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
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#page-top">Hallenbelegungen</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li class="page-scroll">
                            <a href="#hallen">Hallen</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#infos">Über</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#kontakt">Kontakt</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        @yield('content');

        <!-- Footer -->
        <footer class="text-center">
            <div class="footer-above">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-md-6">
                            <h3>Wo sind wir</h3>
                            <p>Bahnhofstraße 10<br>79780 Stühlingen<br>Deutschland</p>
                        </div>
                        <div class="footer-col col-md-6">
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

        <!-- jQuery -->
        {!! Html::script('/js/vendor/jquery.min.js') !!}

        <!-- Bootstrap Core JavaScript -->
        {!! Html::script('/js/vendor/bootstrap.min.js') !!}

        <!-- Plugin JavaScript -->
        {!! Html::script('/js/vendor/jquery.easing.1.3.min.js') !!}
        {!! Html::script('/js/vendor/classie.js') !!}
        {!! Html::script('/js/vendor/cbpAnimatedHeader.js') !!}

        <!-- Custom Theme JavaScript -->
        {!! Html::script('/js/dist/freelancer.min.js') !!}

        <!-- Custom JavaScript-->
        {!! Html::script('/js/dist/scripts.min.js') !!}

    </body>
</html>
