@extends('baselayout')

@section('content')

<!-- Gyms Section -->
<section id="hallen">
    <div class="container">
        <div class="row">
            @for ($i = 0; $i < 3; $i++)
                @include('partials._location-card')
            @endfor
        </div>
    </div>
</section>

<!-- Infos Section -->
@include('partials._infos')

<!-- Contact Section -->
@include('partials._contact')

@stop