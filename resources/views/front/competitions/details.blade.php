@extends('layouts.front')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <h3>{{ $competition->header }}</h3>
            <hr>
            <dl class="dl-horizontal">
                <dt>Datum:</dt>
                <dd>{{ $competition->start_date}}</dd>
                <dt>Meldeschluss:</dt>
                <dd>{{ $competition->submit_date }}</dd>
                <dt>Auszeichnungen:</dt>
                <dd>{{ $competition->award }}</dd>
                <dt>Klassen:</dt>
                <dd>{{ $competition->reduceClasses() }}</dd>
                <dt>sportl. Leitung:</dt>
                <dd>{{ $competition->team->leader }}</dd>
                <dt>Meldeanschrift:</dt>
                <dd>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{ $competition->team->address->name }}<br>
                            {{ $competition->team->address->street }}<br>
                            {{ $competition->team->address->zip }}
                            {{ $competition->team->address->city }}<br> <a href="mailto:{{ $competition->team->address->email }}">{{ $competition->team->address->email }}</a>
                        </div>
                    </div>
                </dd>
                @if ($competition->team->homepage)
                    <dt>Webseite:</dt>
                    <dd><a href="{{ $competition->team->homepage }}">{{ $competition->team->homepage }}</a></dd>
                @endif
                @if (trim($competition->info))
                    <dt><span class="red_font">Info:</dt></dt>
                    <dd>{{ $competition->info }}</dd>
                @endif
                <dt>Haftung:</dt>
                <dd>Veranstalter und Ausrichter &uuml;bernehmen keinerlei Haftung für Sch&auml;den jeglicher Art.</dd>
                @if($competition->register == 0)
                    <dt></dt>
                    <dd>
                        <a class="btn btn-primary" href="/teams/create/{{ $competition->id }}" role="button"><i class="fa fa-pencil"></i> anmelden</a>
                    </dd>
                @endif
            </dl>
            <div class="divider divider-lg"></div>
            <dl class="dl-horizontal">
                <dt></dt>
                <dd>
                    @foreach($competition->Uploads as $upload)
                        @if($upload->type == config('constants.Participators'))
                            <p class="desc"><a href="upload/{{$upload->type}}/{{$upload->filename}}" target="_blank">Teilnehmer</a></p>
                        @endif
                        @if($upload->type == config('constants.Results'))
                            <p class="desc"><a href="upload/{{$upload->type}}/{{$upload->filename}}" target="_blank">Ergebnisliste</a></p>
                        @endif

                    @endforeach
                </dd>
            </dl>
            <div class="divider divider-lg"></div>
            <hr>
            {!! $competition->timetable_1 !!}
        </div>
    </div>
    <div class="callout callout-success">
                        <span>Elektronische Zeitnahme. &Auml;nderungen vorbehalten! Ohne Gew&auml;hr.
                        Die Wettk&auml;mpfe werden nach den g&uuml;ltigen Wettkampfbestimmungen ausgetragen und stehen unter amtlicher Aufsicht.
                        Wir w&uuml;nschen allen Teilnehmern eine gute Anreise und viel Erfolg.</span><br>
    </div>
@endsection