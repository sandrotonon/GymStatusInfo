@extends('baselayout')

@section('content')

<!-- Gyms Section -->
<section id="hallen">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Stadthalle Stühlingen <span class="hidden">Frei</span></h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Panel title <span class="hidden">Teilweise belegt</span></h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Panel title <span class="hidden">Belegt</span></h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
        </div>
        <div class="row keys">
            <div class="col-md-offset-2 col-md-8">
                <p class="small">Legende:</p>
            </div>
            <div class="col-md-offset-2 col-md-8">
                <div class="row">
                    <div class="col-xs-1"><span class="key key-success">belegt</span></div>
                    <div class="col-xs-11">Dieser Veranstaltungsort ist <strong>verfügbar</strong></div>
                </div>
            </div>
            <div class="col-md-offset-2 col-md-8">
                <div class="row">
                    <div class="col-xs-1"><span class="key key-warning">belegt</span></div>
                    <div class="col-xs-11">Dieser Veranstaltungsort ist <strong>teilweise belegt</strong></div>
                </div>
            </div>
            <div class="col-md-offset-2 col-md-8">
                <div class="row">
                    <div class="col-xs-1"><span class="key key-danger">belegt</span></div>
                    <div class="col-xs-11">Dieser Veranstaltungsort ist <strong>belegt</strong></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Infos Section -->
<section class="success" id="infos">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Über diese Seite</h2>
                <hr class="star-light">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-2">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta quaerat nostrum iure nobis corporis nesciunt animi voluptate optio maiores dolores, quis rem quia officiis perspiciatis provident atque quo eaque itaque!</p>
            </div>
            <div class="col-lg-4">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem cumque, dolorum laborum veritatis! Sapiente ut commodi ducimus neque blanditiis natus, similique libero! Labore voluptates sint quasi voluptatem? Animi, modi, reprehenderit?</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="kontakt">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Schreiben Sie uns</h2>
                <hr class="star-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <p>Haben Sie nützliche Informationen für uns? Auf unserer Webseite finden Sie ein Kontaktformular, das Ihre Nachricht direkt an den Vorstand weiterleitet! Wir würden uns freuen, von Ihnen zu hören!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <a href="http://www.ttf-stuehlingen.de/kontakt/" class="btn btn-lg btn-success" target="_blank" title="Neues Fenster: Zum Kontaktformular auf unserer Webseite gehen">
                    Zu unserem Kontktformular gehen <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@stop