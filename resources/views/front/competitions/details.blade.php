@extends('layouts.front')
@section('content')
<div class="col-md-12">


        <h3>{{ $competition->header }}</h3>
        <hr>
        <dl class="row">
            <dt class="col-sm-3">Datum:</dt>
            <dd class="col-sm-9">{{ $competition->start_date}}</dd>
            <dt class="col-sm-3">Meldeschluss:</dt>
            <dd class="col-sm-9">{{ $competition->submit_date }}</dd>
            <dt class="col-sm-3">Auszeichnungen:</dt>
            <dd class="col-sm-9">{{ $competition->award }}</dd>
            <dt class="col-sm-3">Klassen:</dt>
            <dd class="col-sm-9">{{ $competition->reduceClasses() }}</dd>
            <dt class="col-sm-3">sportl. Leitung:</dt>
            <dd class="col-sm-9">{{ $competition->organizer->leader }}</dd>
            <dt class="col-sm-3">Meldeanschrift:</dt>
            <dd class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $competition->organizer->address->name }}<br>
                        {{ $competition->organizer->address->street }}<br>
                        {{ $competition->organizer->address->zip }}
                        {{ $competition->organizer->address->city }}<br> <a href="mailto:{{ $competition->organizer->address->email }}">{{ $competition->organizer->address->email }}</a>
                    </div>
                </div>
            </dd>
            @if ($competition->organizer->homepage)
                <dt class="col-sm-3">Webseite:</dt>
                <dd class="col-sm-9"><a href="{{ $competition->organizer->homepage }}">{{ $competition->organizer->homepage }}</a></dd>
            @endif
            @if (trim($competition->info))
                <dt class="col-sm-3"><span class="red_font">Info:</span></dt></dt>
                <dd class="col-sm-9">{{ $competition->info }}</dd>
            @endif
            <dt class="col-sm-3">Haftung:</dt>
            <dd class="col-sm-9">Veranstalter und Ausrichter &uuml;bernehmen keinerlei Haftung für Sch&auml;den jeglicher Art.</dd>
            @if($competition->register == 0)
                <dt class="col-sm-3"></dt>
                <dd class="col-sm-9">
                    <a class="btn btn-primary" href="/announciators/create/{{ $competition->id }}" role="button"><i class="fa fa-pencil"></i> anmelden</a>
                </dd>
            @endif
            <dt class="col-sm-3">
                <hr></dt>
            <dd class="col-sm-9">
                <hr></dd>
            <dt class="col-sm-3"></dt>
            <dd class="col-sm-9">
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

        <hr>

        {!! $competition->timetable_1 !!}


    <div class="callout callout-success">
                        <span>Elektronische Zeitnahme. &Auml;nderungen vorbehalten! Ohne Gew&auml;hr.
                        Die Wettk&auml;mpfe werden nach den g&uuml;ltigen Wettkampfbestimmungen ausgetragen und stehen unter amtlicher Aufsicht.
                        Wir w&uuml;nschen allen Teilnehmern eine gute Anreise und viel Erfolg.</span><br>
    </div>
      </div>
@endsection