@extends('baselayout')

@section('content')

<!-- Gyms Section -->
<section id="hallen">
    <div class="container">
        <h1 class="text-center">Sporthallen</h1>
        <hr class="star-primary">

        {!! Form::open(['method' => 'POST', 'action' => 'HomeController@filter', 'class' => 'form-horizontal']) !!}
            <div class="form-group filter-locations">
                <label for="date-chooser" class="col-sm-4 control-label">Sporthallen nach Datum filtern</label>
                <div class="col-xs-8 col-sm-4">
                    <div class="input-group date">
                        <input type="text" data-available-dates='["{{ implode('","', $availableDates) }}"]' name="date" value="{{ $date->format('d.m.Y') }}" class="form-control"><span class="input-group-addon btn-primary"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-2">
                    <button type="submit" class="btn btn-primary btn-block">Filtern <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        {!! Form::close() !!}

        @include('errors._list')

        <div class="row grid">
            @if ($locations->count() !== 0)
                @foreach($locations as $location)
                    @include('partials._location-card', ['location' => $location])
                @endforeach
            @else
                <div class="col-xs-12">
                    <p class="text-center">Es sind noch keine freien Plätze verfügbar!</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Infos Section -->
@include('partials._infos')

<!-- Contact Section -->
@include('partials._contact')

@stop