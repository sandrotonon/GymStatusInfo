<div class="form-group">
    {!! Form::label('team', 'Name*', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('team', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Mannschaftsführer*', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('email', 'E-Mail Adresse*', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>
</div>

@if (!$editUser)
    <div class="form-group">
        {!! Form::label('password', 'Passwort*', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
    </div>
@endif

<div class="form-group">
    {!! Form::label('role', 'Rolle*', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::select('role', $roles, $role, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-12 text-right">
        <a href="{{ route('Teams.index') }}" class="btn btn-default">Abbrechen</a>
        {!! Form::button($submitButtonText, ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
    </div>
</div>
