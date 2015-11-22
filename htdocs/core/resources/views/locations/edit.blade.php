@extends('baselayout')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <h3 class="text-center">Sporthalle bearbeiten:</h3>
                <h1 class="text-center">{{ $location->name }}</h1>
                <hr class="star-primary">

                @include('errors._list')

                {!! Form::model($location, ['method' => 'PATCH', 'action' => ['LocationsController@update', $location->slug], 'class' => 'form-horizontal form-location']) !!}

                    @include('locations._form', ['submitButtonText' => 'Sporthalle speichern'])

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

@stop