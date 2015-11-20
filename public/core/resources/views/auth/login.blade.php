@extends('baselayout')

@section('content')

<section>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>Login</h2>
            <hr class="star-primary">
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Fehler!</strong> Anmelden fehlgeschlagen, bitte überprüfen Sie Ihre eingaben.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="/auth/login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="col-md-4 control-label">E-Mail Addresse</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Passwort</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Angemeldet bleiben
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                        Login
                        </button>
                        <a href="/password/email">Passwort vergessen?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@stop