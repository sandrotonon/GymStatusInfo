<div class="col-sm-6 col-md-4">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h2 class="panel-title text-center">{{ $location->name }}<br><small>(<span class="count-all">4</span> freie Plätze)</small></h2>
        </div><!-- Outer panel heading end -->
        <div class="panel-body">
            @foreach($location->getTimes() as $key => $times)
                <div class="panel panel-warning" style="margin-bottom:15px;">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{ $key }} Uhr</h3>
                    </div>
                    <!-- Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="45%">Mannschaft</th>
                                <th colspan="{{ $times->count() }}">Platz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($times['timeslots'] as $time)
                                @if ($time->user !== null)
                                    <tr>
                                        <td>{{ $time->user->team }}</td>
                                        @for($i = 0; $i < $times->count(); $i++)
                                            <td>x</td>
                                        @endfor
                                    </tr>
                                @endif
                            @endforeach
                            @if(Auth::check() && !$times['booked'])
                            <tr class="active">
                                <td>{{ Auth::user()->team }}</td>
                                <td></td>
                                <td><input type="radio" name="name1"></td>
                                <td><input type="radio" name="name1"></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- Inner panel end -->
            @endforeach
        </div><!-- Outer panel body end -->
        @if(Auth::check())
            <div class="panel-footer text-center">
                <button class="btn btn-primary" style="margin-top:0;"><i class="fa fa-check"></i> Speichern</button>
            </div><!-- Outer panel footer end -->
        @endif
    </div><!-- Outer panel end -->
</div>