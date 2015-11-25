@extends('baselayout')

@section('content')

<!-- Gyms Section -->
<section id="hallen">
    <div class="container">
        <div class="row">
            @foreach($locations as $location)
                @include('partials._location-card', ['location' => $location])
            @endforeach
        </div>
    </div>
</section>

<!-- Infos Section -->
@include('partials._infos')

<!-- Contact Section -->
@include('partials._contact')

@stop