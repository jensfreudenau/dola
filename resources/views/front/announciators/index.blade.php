@extends('layouts.front')


@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="page ng-scope">


            <section class="panel panel-default">

                <div class="invoice-inner">
                    <div class="row">
                        <div class="col-xs-10">
                            <p class="size-h3">{{ $competition->header }}</p>
                        </div>
                        <div class="col-xs-8">
                            <dl class="dl-horizontal">
                                <dt>Datum:</dt>
                                <dd>{{ $competition->start_date }}</dd>
                                <dt>Veranstalter:</dt>
                                <dd>{{ $competition->organizer->name }}</dd>
                            </dl>
                            <hr>
                            <div class="row">
                                <table class="table table-hover">
                                    <thead class="thead-inverse">
                                    <tr>
                                        <th>Vorname</th>
                                        <th>Nachname</th>
                                        <th>Geb. Jahr</th>
                                        <th>Altersklasse</th>
                                        <th>Disziplin</th>
                                        <th>Bestzeit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($participators as $participator)
                                        <tr>
                                            <td>{{$participator->prename}}</td>
                                            <td>{{$participator['lastname'] }}</td>
                                            <td>{{$participator['birthyear'] }}</td>
                                            <td>{{$participator['age_group'] }}</td>
                                            <td>{{$participator['discipline'] }}</td>
                                            <td>{{$participator['best_time'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>

        </div>
        </div>
    </div>

@endsection