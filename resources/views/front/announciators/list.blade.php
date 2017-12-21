@extends('layouts.front')
@section('content')

    <h3>{{ $competition->header }}</h3>
    <dl class="dl-horizontal">
        <dt>Datum:</dt>
        <dd>{{ $competition->start_date }}</dd>
        <dt>Veranstalter:</dt>
        <dd>{{ $competition->organizer->name }}</dd>
        <dd>{{ $competition->organizer->address->name }}</dd>
        <dd>{{ $competition->organizer->address->telephone }}</dd>
        <dd>{{ $competition->organizer->address->email }}</dd>
    </dl>
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
                <td>{{$participator->ageclass->shortname }}</td>
                <td>{{$participator->discipline->shortname }}</td>
                <td>{{$participator['best_time'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>




@endsection