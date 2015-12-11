@extends('baselayout')

@section('content')

<section>
    <div class="container">
        <h1 class="text-center">Login</h1>
        <hr class="star-primary">

        @include('errors._list')

        <form class="form-horizontal" role="form" method="POST" action="/auth/login">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-sm-4 control-label">E-Mail Addresse</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Passwort</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" name="password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Angemeldet bleiben
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-4">
                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                    Login
                    </button>
                    <a href="/password/email">Passwort vergessen?</a>
                </div>
            </div>
        </form>
    </div>
</section>

@stop