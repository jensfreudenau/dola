@extends('layouts.front')
@section('content')

    <div class="card card-default mb-5 p-3">
        <h3>Anmeldung</h3>
        {!! Form::open(['method' => 'POST', 'route' => ['announciators/massupload']]) !!}

        <div class="form-group">

            @foreach ($competitions as $competition)
                @if ($competition->only_list) @continue; @endif
                @if ($competition->register) @continue; @endif
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="competition_id" id="{{$competition->id}}" value="{{$competition->id}}">
                        <label class="form-check-label" for="{{$competition->id}}">
                            {{$competition->header}}
                            <p class="desc">
                                @foreach ($competition->ageclasses as $ageclass)
                                    <span class="entry_tags">
                                {{$ageclass->ladv}}@if (!$loop->last)@endif
                            </span>
                                @endforeach
                            </p>
                            <p class="desc">
                                @foreach ($competition->disciplines as $disciplines)
                                    <span class="entry_tags">
                                {{$disciplines->shortname}}@if (!$loop->last)@endif
                            </span>
                                @endforeach
                            </p>
                        </label>

                    </div> <br>
            @endforeach
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
        <li>Die erste Zeile der CSV Datei ist eine Überschrift und wird nicht ausgewertet.</li>
        <li>Vorname, Nachname und Geburtsjahr sind Pflichtfelder.</li>
        <li>Die Felder in der Excel Tabelle müssen das Textformat haben. Sonst werden die Disziplinen und Altersklassen falsch von Excel formatiert.</li>
        <li>Die Exceldatei als CSV exportieren, mit Semikolon als Trennzeichen. Das Semikolon ist normalerweise standardmäßig als Trennzeichen eingestellt. (<a href="https://www.anleitung24.com/anleitung-csv-datei-mit-excel-erstellen-trennzeichen-selbst-bestimmen.html" target="_blank">Anleitung</a>) </li>
        <li>Die Werte für die Altersklassen und der Disziplinen müssen mit denen der Ausschreibung übereinstimmen. Die können aber in dem Formular noch geändert werden, falls sie rot markiert wurden.</li>
    </ul>
    <p><a href="{{ url('/storage') }}/teilnehmer.xlsx" target="_blank">Beispieldatei</a></p>

@stop

