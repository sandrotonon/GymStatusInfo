@extends('baselayout')

@section('content')

<!-- Gyms Section -->
<section id="hallen">
    <div class="container">
        @if (Auth::check())
            <a href="sporthallen/neu" class="btn btn-primary">Sporthalle hinzufügen</a>

            @foreach ($locations as $location)
                <h3><a href="sporthallen/{{ $location->slug }}/bearbeiten">{{ $location->name }}</a></h3>
                <p>{{ $location->city }}</p>
            @endforeach
        @else
            <div class="row">
                @for ($i = 0; $i < 3; $i++)
                    @include('partials._location-card')
                @endfor
            </div>
        @endif
    </div>
</section>

<!-- Infos Section -->
@include('partials._infos')

<!-- Contact Section -->
@include('partials._contact')

@stop