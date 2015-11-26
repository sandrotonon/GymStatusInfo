@extends('baselayout')

@section('content')

<!-- Gyms Section -->
<section id="hallen">
    <div class="container">
        <h1 class="text-center">Sporthallen</h1>
        <hr class="star-primary">

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