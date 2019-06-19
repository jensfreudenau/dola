@extends('layouts.front')
@section('content')

    <div class="card card-default mb-5 p-3">
        <h3>Massen Anmeldung</h3>
        {!! Form::open(['method' => 'POST', 'route' => ['announciators/massupload']]) !!}
        <div class="form-group">
            {!! Form::label('competition_id', Lang::get('quickadmin.competitions.title'), ['class' => 'control-label']) !!}
            {!! Form::select('competition_id', $competitionselect, null, ['id'=> 'competition_id', 'class' => 'competition_select form-control','style'=>'width: 100%']) !!}
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="form-group float-right">
                    <div class="input-group">
                        {!! Form::button('<i class="fa fa-pencil" aria-hidden="true">
                        </i>&nbsp;auswählen', array('class' => 'btn btn-outline-primary', 'type' => 'submit')) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('hash',$hash) !!}
        {!! Form::close() !!}

    </div>
    <h3>Hinweise</h3>
    <ul>
        <li>Die erste Zeile wird nicht importiert.</li>
        <li>Vorname und Nachname sind Pflichtfelder.</li>
        <li>Die Felder in der Excel Tabelle müssen das Textformat haben.</li>
        <li>Die Exceldatei als CSV exportieren. Mit Semikolon als Trennzeichen (<a href="https://www.anleitung24.com/anleitung-csv-datei-mit-excel-erstellen-trennzeichen-selbst-bestimmen.html" target="_blank">Anleitung</a>) </li>
        <li>Die Werte für die Altersklassen und der Disziplinen müssen mit denen der Ausschreibung übereinstimmen (nächste Seite, nach Auswahl des Wettkampfes). Die können aber noch geändert werden</li>
    </ul>
    <p><a href="{{ url('public/storage') }}/teilnehmer.xlsx" target="_blank">Beispieldatei</a></p>

@stop

