@extends('baselayout')

@section('content')

@include('partials._breadcrumbs')

<section class="management management-locations">
    <div class="container">
        <h1 class="text-center">Sporthallen</h1>
        <hr class="star-primary">

        <div class="row search">
            <div class="col-xs-12 col-sm-8 col-md-9">
                <div class="input-group right-inner-addon">
                    <input type="search" data-table="table-hover" class="light-table-filter form-control" placeholder="Sporthalle suchen...">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                </div><!-- /input-group -->
            </div><!-- /.col-xs-6 -->
            <div class="col-xs-12 col-sm-4 col-md-3">
                <a href="{{ route('Locations.create') }}" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Sporthalle hinzufügen</a>
            </div>
        </div><!-- /.row -->

        @if ($locations->count() == 0)
            <p class="text-center">Es sind noch keine Sporthallen vorhanden.</p>
        @else
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Sporthalle</th>
                        <th>Verfügbare Termine</th>
                        <th class="text-right">Verwaltung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $location)
                        <tr>
                            <td scope="row">{{ $location->name }}</td>
                            <td>{{ $location->times->count() }}</td>
                            <td class="text-right">
                                {!! Form::open(['method' => 'DELETE', 'action' => ['LocationsController@destroy', $location->id], 'class' => 'inline-form']) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['data-toggle' => 'confirmation tooltip', 'title' => $location->name . ' löschen', 'data-placement' => 'top', 'class' => 'btn btn-xs btn-link', 'type' => 'submit']) !!}
                                {!! Form::close() !!}
                                <a href="{{ route('Locations.{slug}.edit', $location->slug) }}" class="btn btn-xs btn-link" data-toggle="tooltip" data-placement="top" title="{{ $location->name }} bearbeiten"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

@stop