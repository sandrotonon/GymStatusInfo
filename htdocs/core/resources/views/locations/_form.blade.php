<div class="form-group">
    {!! Form::label('name', 'Name*', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('city', 'Stadt', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('city', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('street', 'Straße und Hausnummer', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('street', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('country', 'Land', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::select('country', array('Deutschland' => 'Deutschland'), 'Deutschland', ['class' => 'form-control']) !!}
    </div>
</div>

<div class="pb-10"></div>

<h3 class="text-center">Termine</h3>

@if (empty($timeSlots))
    <p class="text-center">Es sind noch keine Termine vorhanden.</p>
    <div class="pb-10"></div>
@else
    {!! Form::hidden('timeslotdates', $timeslotdates, ['id' => 'timeSlotDates']); !!}

    <table class="table table-hover table-striped" id="timeSlotTable">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Uhrzeit</th>
                <th>Plätze</th>
                <th class="text-right">Verwaltung</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timeSlots as $timeSlot)
                <tr>
                    <td>{{ date('d.m.Y', strtotime($timeSlot->date)) }}</td>
                    <td>{{ date('H:i', strtotime($timeSlot->time)) }}</td>
                    <td>{{ $timeSlot->places }}</td>
                    <td class="text-right"><a href='javascript:void(0);' class='btn btn-xs btn-link deleteRow' data-toggle='tooltip' data-placement='top' title='Termin löschen'><i class='fa fa-trash'></i></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<div class="row">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="panel panel-success">
          <div class="panel-heading">
              <h3 class="panel-title">Termin hinzufügen</h3>
          </div>
          <div class="panel-body">
              <div class="form-group">
                  {!! Form::label('date', 'Datum', ['class' => 'col-md-4 control-label']) !!}
                  <div class="col-md-6">
                      {!! Form::date('date', null, ['class' => 'form-control']) !!}
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('time', 'Uhrzeit', ['class' => 'col-md-4 control-label']) !!}
                  <div class="col-md-6">
                      {!! Form::time('time', null, ['class' => 'form-control']) !!}
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('places', 'Plätze', ['class' => 'col-md-4 control-label']) !!}
                  <div class="col-md-6">
                      {!! Form::number('places', null, ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-md-offset-4 col-md-6">
                      {!! Form::button('<i class="fa fa-plus"></i> Termin hinzufügen',
                      ['id' => 'add-time', 'class' => 'btn btn-success addRow']) !!}
                  </div>
              </div>
          </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 text-right">
        <a href="{{ route('Locations.index') }}" class="btn btn-default">Abbrechen</a>
        {!! Form::button($submitButtonText, ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
    </div>
</div>
