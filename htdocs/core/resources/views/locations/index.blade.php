@extends('baselayout')

@section('content')

@include('partials._breadcrumbs')

<section>
    <div class="container">
        <h1 class="text-center">Sporthallen</h1>
        <hr class="star-primary">

        <div class="row search-location">
            <div class="col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Sporthalle suchen...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button">Suchen!</button>
                    </span>
                </div><!-- /input-group -->
            </div><!-- /.col-xs-6 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-6">Sporthalle</div>
                <div class="col-xs-6">Verfügbare Termine</div>
            </div>
        </div>

        <hr>

        @foreach ($locations as $location)
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6"><strong>{{ $location->name }}</strong></div>
                        <div class="col-xs-6"><strong>{{ $location->times->count() }}</strong></div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    {!! Form::open(['method' => 'DELETE', 'action' => ['LocationsController@destroy', $location->id], 'class' => 'inline-form']) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> Sporthalle löschen', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                    <a href="{{ route('Locations.{slug}.edit', $location->slug) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Sporthalle bearbeiten</a>
                </div>
            </div>
        @endforeach

        <div class="row">
            <div class="col-xs-12 text-right">
                <a href="{{ route('Locations.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Sporthalle hinzufügen</a>
            </div>
        </div>
    </div>
</section>

@stop