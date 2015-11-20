@extends('baselayout')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                @foreach ($locations as $location)
                    <h2>
                        <a href="{{ url('hallen', $location->slug) }}">{{ $location->name }}</a>
                    </h2>

                    <p>{{ $location->description }}</p>
                @endforeach
            </div>
        </div>
    </div>
</section>

@stop