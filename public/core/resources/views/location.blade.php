@extends('baselayout')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <h1>{{ $location->name }}</h1>
            </div>
        </div>
    </div>
</section>

@stop