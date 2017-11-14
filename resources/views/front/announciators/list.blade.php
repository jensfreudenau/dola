@extends('layouts.front')
@section('content')

            <p class="size-h3">{{ $competition->header }}</p>


            <dl class="dl-horizontal">
                <dt>Datum:</dt>
                <dd>{{ $competition->start_date }}</dd>
                <dt>Veranstalter:</dt>
                <dd>{{ $competition->organizer->name }}</dd>
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
                            <td>{{$participator['age_group'] }}</td>
                            <td>{{$participator['discipline'] }}</td>
                            <td>{{$participator['best_time'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>




@endsection