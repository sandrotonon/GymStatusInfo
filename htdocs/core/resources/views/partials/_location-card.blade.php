<div class="col-xs-12 col-sm-6 col-md-4 location">
    <?php
        $type = 'book';
        if ($location->booked) {
            $type = 'unbook';
        }
    ?>
    {!! Form::open(['method' => 'PATCH', 'route' => [$type, 'id' => $location->id], 'class' => 'panel panel-primary']) !!}

        <div class="overlay">
            <div class="content-wrapper">
                <div class="booking-progress">
                    <p class="text-center">
                        Wird reserviert ...
                    </p>
                    <div class="spinner">
                        <div class="spinner__item1"></div>
                        <div class="spinner__item2"></div>
                        <div class="spinner__item3"></div>
                        <div class="spinner__item4"></div>
                    </div>
                </div>
                <div class="booking-progress-response text-center booking-progress-success">
                    <div class="icon">
                        <i class="fa fa-check-circle fa-4x"></i>
                    </div>
                    <p>Reservierung erfolgreich!</p>
                </div>
                <div class="booking-progress-response text-center booking-progress-error">
                    <div class="icon">
                        <i class="fa fa-times-circle fa-4x"></i>
                    </div>
                    <p>Reservierung fehlgeschlagen!</p>
                </div>
            </div>
        </div>

        <?php
            $freeslotsSuffix = ($location->freeslots === 0 || $location->freeslots > 1) ? ' Freie Plätze' : ' Freier Platz';
        ?>
        <div class="panel-heading">
            <h2 class="panel-title text-center">{{ $location->name }}<br><small>(<span class="count-all">{{ $location->freeslots }}</span>{{ $freeslotsSuffix }})</small></h2>
        </div><!-- Outer panel heading end -->
        <div class="panel-body">
            @foreach($location->times as $time => $times)
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
                <div class="panel panel-{{ $status }}">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{ Carbon\Carbon::createFromFormat('H:i:s', $time)->format('H:i') }} Uhr</h3>
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
                                        <?php $teamname = (Auth::check() && $timeslot->user->team === Auth::user()->team) ? '<strong>' . $timeslot->user->team . '</strong>' : $timeslot->user->team; ?>
                                        <td>{!! $teamname !!}</td>
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
                                <tr>
                                    <td><strong>{{ Auth::user()->team }}</strong></td>
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
            @if($location->freeslots === 0)
                @if($location->booked)
                    <div class="panel-footer text-center">
                        {!! Form::button('<i class="fa fa-times"></i> Reservierung löschen', ['type' => 'submit', 'class' => 'btn btn-danger btn-book btn-book-unbook', 'style' => 'margin-top:0;']) !!}
                    </div>
                @endif
            @else
                <div class="panel-footer text-center">
                    @if($location->booked)
                        {!! Form::button('<i class="fa fa-times"></i> Reservierung löschen', ['type' => 'submit', 'class' => 'btn btn-danger btn-book btn-book-unbook', 'style' => 'margin-top:0;']) !!}
                    @else
                        {!! Form::button('<i class="fa fa-check"></i> Reservierung speichern', ['type' => 'submit', 'class' => 'btn btn-primary btn-book btn-book-book', 'style' => 'margin-top:0;']) !!}
                    @endif
                </div>
            @endif
        @endif

    {!! Form::close() !!}
</div>