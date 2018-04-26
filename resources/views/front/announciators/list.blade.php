@extends('layouts.front')
@section('content')
    <div class="card card-default mb-5 p-3">
        <h3>{{ $list['competition']->header }}</h3>
        <dl class="dl-horizontal">
            <dt>Datum:</dt>
            <dd>{{ $list['competition']->start_date }}</dd>
            <dt>Veranstalter:</dt>
            <dd>{{ $list['competition']->organizer->name }}</dd>
            <dd>{{ $list['competition']->organizer->address->name }}</dd>
            <dd>{{ $list['competition']->organizer->address->telephone }}</dd>
            <dd>{{ $list['competition']->organizer->address->email }}</dd>
        </dl>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-inverse">
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Verein</th>
                    <th>Geb. Jahr</th>
                    <th>Altersklasse</th>
                    <th>@lang('quickadmin.participator.fields.discipline')</th>
                    <th>Bestzeit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list['announciator']->Participator as $participator)
                    <tr>
                        <td>{{$participator->prename}}</td>
                        <td>{{$participator->lastname }}</td>
                        <td>{{$participator->clubname }}</td>
                        <td>{{$participator->birthyear }}</td>
                        <td>{{$participator->ageclass->shortname }}</td>
                        @if(!empty($participator->discipline))
                            <td>{{$participator->discipline}}</td>
                        @else
                            <td>&nbsp;</td>
                        @endif
                        <td>{{$participator['best_time'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection