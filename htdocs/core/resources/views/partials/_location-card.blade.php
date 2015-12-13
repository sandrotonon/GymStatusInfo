<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 location">
    <?php $type = ($location->booked) ? 'unbook' : 'book'; ?>

    {!! Form::open(['method' => 'PATCH', 'route' => [$type, 'id' => $location->id], 'class' => 'panel panel-primary', 'data-location' => $location->id]) !!}

        <div class="overlay">
            <div class="content-wrapper">
                <div class="booking-progress">
                    <p class="text-center">
                    </p>
                    <div class="spinner">
                        <div class="spinner__item1"></div>
                        <div class="spinner__item2"></div>
                        <div class="spinner__item3"></div>
                        <div class="spinner__item4"></div>
                    </div>
                </div>
                <div class="booking-response text-center booking-success">
                    <div class="icon">
                        <i class="fa fa-check-circle fa-4x"></i>
                    </div>
                    <p class="response"></p>
                </div>
                <div class="booking-response text-center booking-error">
                    <div class="icon">
                        <i class="fa fa-times-circle fa-4x"></i>
                    </div>
                    <p class="response"></p>
                </div>
            </div>
        </div>

        <?php
            $freeslotsSuffix = ($location->freeslots === 0 || $location->freeslots > 1) ? ' Freie Plätze' : ' Freier Platz';
        ?>
        <div class="panel-heading" data-free-slots="{{ $location->freeslots }}">
            <h2 class="panel-title text-center">{{ $location->name }}<br><small class="count-all">({{ $location->freeslots }}{{ $freeslotsSuffix }})</small></h2>
        </div><!-- Outer panel heading end -->
        <div class="panel-body">
            @foreach($location->times as $time => $times)
                <?php
                    $freeslots = $times['freeslots'];
                    $totalslots = $times['totalslots'];
                    $status = 'success';

                    if ($freeslots === 0) {
                        $status = 'danger';
                    } elseif ($freeslots / $totalslots * 100 <= 50) {
                        $status = 'warning';
                    }
                ?>
                <div class="panel panel-{{ $status }}" data-free-slots="{{ $freeslots = $times['freeslots'] }}" data-total-slots="{{ $totalslots }}" data-time="{{ Carbon\Carbon::createFromFormat('H:i:s', $time)->format('H:i') }}">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{ Carbon\Carbon::createFromFormat('H:i:s', $time)->format('H:i') }} Uhr</h3>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <?php
                                $colspan = $times['timeslots']->count();
                            ?>

                            <thead>
                                <tr>
                                    <th width="45%"></th>
                                    <th colspan="{{ $colspan }}" class="text-center"><small>Platz</small></th>
                                </tr>
                                <tr>
                                    <th width="45%"><small>Mannschaft</small></th>
                                    @for($i = 1; $i <= $totalslots; $i++)
                                        <th class="text-center"><small>{{ $i }}</small></th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <?php $booked = ($times['booked']) ? 'hidden' : '' ?>

                                @foreach($times['timeslots'] as $timeslot)
                                    @if($timeslot->user_id !== null)
                                        <?php
                                            $inputRow = (Auth::check() && $timeslot->user->team === Auth::user()->team) ? 'input-row' : '';
                                        ?>
                                        <tr class="{{ $inputRow }}">
                                            <?php
                                                $teamname = (Auth::check() && $timeslot->user->team === Auth::user()->team) ? '<strong>' . $timeslot->user->team . '</strong>' : $timeslot->user->team;
                                            ?>
                                            <td width="45%">{!! $teamname !!}</td>
                                            @for($i = 0; $i < $times['timeslots']->count(); $i++)
                                                <?php
                                                    $available = ($times['timeslots'][$i]->user_id === null) ? 1 : 0;
                                                    $bookedByUser = (Auth::check() && $times['timeslots'][$i]->user_id === Auth::user()->id && $timeslot->user->team === Auth::user()->team) ? 1 : 0;
                                                ?>
                                                <td width="{{ 100 / $times['timeslots']->count() }}" class="text-center" data-available="{{ $available }}" data-timeslot-id="{{ $times['timeslots'][$i]->id }}" data-booked-by-user="{{ $bookedByUser }}">
                                                    @if($times['timeslots'][$i]->user_id !== null
                                                        && $timeslot->user->team === $times['timeslots'][$i]->user->team)
                                                        <i class="fa fa-check"></i><span class="sr-only">Platz belegt</span>
                                                    @elseif($available === 0)
                                                        <span class="sr-only">Platz belegt</span>
                                                    @else
                                                        <span class="sr-only">Platz noch nicht belegt</span>
                                                    @endif
                                                </td>
                                            @endfor
                                        </tr>
                                    @endif
                                @endforeach

                                @if(!$times['booked'] && $freeslots > 0 && Auth::check())
                                    <tr class="input-row {{ $booked }}">
                                        <td><strong>{{ Auth::user()->team }}</strong></td>
                                        @for($i = 0; $i < $times['timeslots']->count(); $i++)
                                            <?php
                                                $available = ($times['timeslots'][$i]->user_id === null) ? 1 : 0;
                                                $bookedByUser = (Auth::check() && $times['timeslots'][$i]->user_id === Auth::user()->id) ? 1 : 0;
                                            ?>
                                            <td class="text-center" data-available="{{ $available }}" data-timeslot-id="{{ $times['timeslots'][$i]->id }}" data-booked-by-user="{{ $bookedByUser }}">
                                                @if($times['timeslots'][$i]->user_id === null)
                                                    <input type="radio" value="{{ $times['timeslots'][$i]->id }}" name="timeslot-{{ $time }}">
                                                @else
                                                    <span class="sr-only">Platz belegt</span>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endif

                                @if(!Auth::check() && $totalslots == $freeslots)
                                    <tr class="no-bookings {{ $booked }}">
                                        <td colspan="{{ $totalslots + 1 }}" class="text-center"><strong>Keine Reservierungen vorhanden!</strong></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
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