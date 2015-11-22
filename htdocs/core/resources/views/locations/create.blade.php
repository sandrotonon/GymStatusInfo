@extends('baselayout')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <h1 class="text-center">Halle hinzufügen</h1>
                <hr class="star-primary">

                @include('errors._list')

                {!! Form::open(['action' => 'LocationsController@store', 'class' => 'form-horizontal form-loaction']) !!}

                    @include('locations._form', ['submitButtonText' => 'Sporthalle hinzufügen'])

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

@stop