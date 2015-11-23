@extends('baselayout')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            {!! Breadcrumbs::render('Teams.{slug}.edit', $user) !!}
        </div>
    </div>
</div>

<section>
    <div class="container">
        <h3 class="text-center">Mannschaft bearbeiten:</h3>
        <h1 class="text-center">{{ $user->team }}</h1>
        <hr class="star-primary">

        @include('errors._list')

        {!! Form::model($user, ['method' => 'PATCH', 'action' => ['TeamsController@update', $user->slug], 'class' => 'form-horizontal form-location']) !!}

            @include('teams._form', ['submitButtonText' => 'Mannschaft speichern', 'editUser' => true])

        {!! Form::close() !!}
    </div>
</section>

@stop