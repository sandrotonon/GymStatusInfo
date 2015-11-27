@extends('baselayout')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            {!! Breadcrumbs::render('profile.{slug}.edit', $user->team) !!}
        </div>
    </div>
</div>

<section>
    <div class="container">
        <h3 class="text-center">Passwort bearbeiten:</h3>
        <h1 class="text-center">{{ $user->name }}</h1>
        <hr class="star-primary">

        @include('errors._list')

        {!! Form::open(['method' => 'PATCH', 'action' => ['TeamsController@updateProfile', $user->id], 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                <label for="oldpw" class="col-md-4 control-label">Aktuelles Passwort*</label>
                <div class="col-md-8">
                    <input type="password" id="oldpw" class="form-control" name="oldpassword">
                </div>
            </div>

            <div class="form-group">
                <label for="newpw" class="col-md-4 control-label">Neues Passwort*</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="newpw" name="newpassword">
                </div>
            </div>

            <div class="form-group">
                <label for="newpwconf" class="col-md-4 control-label">Neues Passwort bestätigen*</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="newpwconf" name="newpassword_confirmation">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="{{ route('index') }}" class="btn btn-default">Abbrechen</a>
                    {!! Form::button('Passwort ändern', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                </div>
            </div>

        {!! Form::close() !!}
    </div>
</section>

@stop