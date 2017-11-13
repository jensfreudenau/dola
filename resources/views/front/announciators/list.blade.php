@extends('layouts.front')
@section('content')
    <hr>
    <div class="row">
        <div class="col-xs-12">
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

                    @foreach($announciator->Participator as $participator)
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
        <div class="col-xs-4"></div>
    </div>


@endsection