@extends('baselayout')

@section('content')

@include('partials._breadcrumbs')

<section>
    <div class="container">
        <h1 class="text-center">Sporthalle hinzufügen</h1>
        <hr class="star-primary">

        @include('errors._list')

        {!! Form::open(['action' => 'LocationsController@store', 'class' => 'form-horizontal form-loaction']) !!}

            @include('locations._form', ['submitButtonText' => '<i class="fa fa-plus"></i> Sporthalle hinzufügen'])

        {!! Form::close() !!}
    </div>
</section>

@stop