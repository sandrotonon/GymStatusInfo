@extends('baselayout')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <h1 class="text-center">Halle hinzufügen</h1>
                <hr class="star-primary">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::open(['url' => 'hallen', 'class' => 'form-horizontal']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Name*', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('city', 'Stadt', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('city', old('city'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('street', 'Straße / Hausnummer', ['class' => 'col-xs-12 col-md-4 text-left control-label']) !!}
                    <div class="col-xs-8 col-md-6">
                        {!! Form::text('street', old('street'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-xs-4 col-md-2">
                        {!! Form::text('number', old('number'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('country', 'Land', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::select('country', array('Deutschland'), 'Deutschland', ['class' => 'form-control']) !!}
                    </div>
                </div>

                <h3 class="text-center">Uhrzeiten</h3>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Freie Zeit hinzufügen</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label('time', 'Uhrzeit', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::time('time', old('time'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('places', 'Plätze', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::number('places', old('places'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                {!! Form::button('Zeit hinzufügen', ['class' => 'btn btn-success']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        {!! Form::submit('Halle hinzufügen', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

@stop