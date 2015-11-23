@extends('baselayout')

@section('content')

<!-- Gyms section -->
<section id="hallen">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                @foreach ($locations as $location)
                    <h3>{{ $location->name }}</h3>
                    <p>{{ $location->city }}</p>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Timeslots section -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <h1>Timeslots</h1>
                @foreach ($timeslots as $timeslot)
                    <h3>{{ $timeslot->date->format('d.m.Y') }}</h3>

                    @if ($timeslot->user != null)
                        <p>Gebucht von: {{ $timeslot->user->name }}</p>
                        <p>Ist in: {{ $timeslot->location->name }}</p>
                    @else
                        Noch nicht gebucht
                    @endif
                @endforeach

                <h1>Nächste Timeslots</h1>
                @foreach ($relevantLocations as $location)
                    <h4>Wo: {{ $location }}</h4>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Infos Section -->
@include('partials._infos')

<!-- Contact Section -->
@include('partials._contact')

@stop