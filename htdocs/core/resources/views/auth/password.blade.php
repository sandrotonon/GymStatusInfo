@extends('baselayout')

@section('content')

<section>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>Passwort zurücksetzen</h2>
            <hr class="star-primary">
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Fehler!</strong> Passwort zurücksetzen fehlgeschlagen, bitte überprüfen Sie Ihre Eingaben.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" class="form-horizontal" action="/password/email">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="col-md-4 control-label">E-Mail Addresse</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Passwort zurücksetzen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@stop
