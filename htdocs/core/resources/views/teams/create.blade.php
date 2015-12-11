@extends('baselayout')

@section('content')

@include('partials._breadcrumbs')

<section class="management">
    <div class="container">
        <h1 class="text-center">Mannschaft hinzufügen</h1>
        <hr class="star-primary">

        @include('errors._list')

        {!! Form::open(['action' => 'TeamsController@store', 'class' => 'form-horizontal form-loaction']) !!}

            @include('teams._form', ['submitButtonText' => '<i class="fa fa-plus"></i> Mannschaft hinzufügen', 'editUser' => false])

        {!! Form::close() !!}
    </div>
</section>

@stop