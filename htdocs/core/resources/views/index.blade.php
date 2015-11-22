@extends('baselayout')

@section('content')

<!-- Gyms Section -->
<section id="hallen">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                @if (Auth::check())
                    <a href="sporthallen/neu" class="btn btn-primary">Sporthalle hinzufügen</a>

                    @foreach ($locations as $location)
                        <h3><a href="sporthallen/{{ $location->slug }}/bearbeiten">{{ $location->name }}</a></h3>
                        <p>{{ $location->city }}</p>
                    @endforeach
                @else
                    Nicht angemeldet
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Infos Section -->
@include('partials._infos')

<!-- Contact Section -->
@include('partials._contact')

@stop