@extends('baselayout')

@section('content')

@include('partials._breadcrumbs')

<section>
    <div class="container">
        <h1 class="text-center">Mannschaften</h1>
        <hr class="star-primary">

        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-6">Mannschaft</div>
                <div class="col-xs-6">Mannschaftsführer</div>
            </div>
        </div>

        <hr>

        @foreach ($users as $user)
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6"><strong>{{ $user->team }}</strong></div>
                        <div class="col-xs-6"><strong>{{ $user->name }}</strong></div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    {!! Form::open(['method' => 'DELETE', 'action' => ['TeamsController@destroy', $user->id], 'class' => 'inline-form']) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> Mannschaft löschen', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                    <a href="{{ route('Teams.{slug}.edit', $user->slug) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Mannschaft bearbeiten</a>
                </div>
            </div>
        @endforeach

        <div class="row">
            <div class="col-xs-12 text-right">
                <a href="{{ route('Teams.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Mannschaft hinzufügen</a>
            </div>
        </div>
    </div>
</section>

@stop