@extends('baselayout')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <h1 class="text-center">Mannschaften</h1>
                <hr class="star-primary">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-6">Mannschaft</div>
                        <div class="col-xs-6">Mannschaftsführer</div>
                    </div>
                </div>

                <hr>

                @foreach ($users as $user)

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">{{ $user->team }}</div>
                                <div class="col-xs-6">{{ $user->name }}</div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <button href="#removeItem" class="btn btn-danger"><i class="fa fa-trash"></i> Mannschaft Löschen</button>
                            <button href="#editItem" class="btn btn-primary"><i class="fa fa-pencil"></i> Mannschaft bearbeiten</button>
                        </div>
                    </div>

                @endforeach

                <div class="row">
                    <div class="col-xs-offset-8 col-xs-4">
                        <a href="mannschaften/neu" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Mannschaft hinzufügen</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@stop