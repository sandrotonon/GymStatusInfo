<div class="col-sm-6 col-md-4">
    <?php
        $type = 'book';
        if ($location->booked) {
            $type = 'unbook';
        }
    ?>
    {!! Form::open(['method' => 'PATCH', 'route' => ['book', 'id' => $location->id, 'type' => $type], 'class' => 'panel panel-success']) !!}

        <div class="panel-heading">
            <h2 class="panel-title text-center">{{ $location->name }}<br><small>(<span class="count-all">4</span> freie Plätze)</small></h2>
        </div><!-- Outer panel heading end -->
        <div class="panel-body">
            @foreach($location->getTimes() as $key => $times)
                <?php
                    $freeslots = $times['freeslots'];
                    $totalslots = $times['totalslots'];
                    $status = 'success';

                    if ($freeslots === 0) {
                        $status = 'danger';
                    } elseif ($freeslots / $totalslots * 100 < 50) {
                        $status = 'warning';
                    }
                ?>
                <div class="panel panel-{{ $status }}" style="margin-bottom:15px;">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{ $key }} Uhr</h3>
                    </div>
                    <!-- Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="45%">Mannschaft</th>
                                <th colspan="{{ $times['timeslots']->count() }}">Platz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($times['timeslots'] as $timeslot)
                                @if($timeslot->user_id !== null)
                                    <tr>
                                        <td>{{ $timeslot->user->team }}</td>
                                        @for($i = 0; $i < $times['timeslots']->count(); $i++)
                                            <td width="{{ 100 / $times['timeslots']->count() }}" class="text-center">
                                                @if($times['timeslots'][$i]->user_id !== null
                                                    && $timeslot->user->team === $times['timeslots'][$i]->user->team)
                                                    <i class="fa fa-check"></i><span class="sr-only">belegt</span>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endif
                            @endforeach
                            @if(Auth::check() && !$location->booked && $times['freeslots'] !== 0)
                                <tr class="active">
                                    <td>{{ Auth::user()->team }}</td>
                                    @for($i = 0; $i < $times['timeslots']->count(); $i++)
                                        <td width="{{ 100 / $times['timeslots']->count() }}" class="text-center">
                                            @if($times['timeslots'][$i]->user_id === null)
                                                <input type="radio" value="{{ $times['timeslots'][$i]->id }}" name="timeslot">
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @elseif($freeslots === $totalslots)
                                <tr>
                                    <td colspan="2" class="text-center"><strong>Noch keine Reservierungen vorhanden!</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- Inner panel end -->
            @endforeach
        </div><!-- Outer panel body end -->
        @if(Auth::check())
            <div class="panel-footer text-center">
                @if(!$location->booked)
                    {!! Form::button('<i class="fa fa-check"></i> Reservierung speichern', ['type' => 'submit', 'class' => 'btn btn-primary', 'style' => 'margin-top:0;']) !!}
                @else
                    {!! Form::button('<i class="fa fa-times"></i> Reservierung löschen', ['type' => 'submit', 'class' => 'btn btn-danger', 'style' => 'margin-top:0;']) !!}
                @endif
            </div><!-- Outer panel footer end -->
        @endif

    {!! Form::close() !!}
</div>