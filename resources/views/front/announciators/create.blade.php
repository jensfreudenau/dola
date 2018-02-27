@extends('layouts.front')
@section('content')
    <div class="card card-default mb-5 p-3">
        <h3>Anmeldung</h3>
        {!! Form::open(['method' => 'POST', 'route' => ['announciators/store']]) !!}
        <div class="form-group">
            {!! Form::label('competition_id', Lang::get('quickadmin.competitions.title'), ['class' => 'control-label']) !!}
            {!! Form::select('competition_id', $competitionselect, ( $competition ? $competition->id: null), ['id'=> 'competition_id', 'class' => 'competition_select form-control','style'=>'width: 100%']) !!}
        </div>
        <div class="form-group">
            <div class="input-group">
                <input class="form-control" placeholder="Datum" id="start_date" name="start_date" disabled value="{{ $competition ?  $competition->start_date : null}}">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input class="form-control" placeholder="Titel" id="header" name="header" disabled required value="{{ $competition ?  $competition->header : null}}">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input class="form-control" placeholder="Veranstalter" disabled id="organizer_name" name="organizer_name" value="{{ $competition ?  $competition->organizer->name : null}}">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                {!! Form::email('email',null, ['id'=> 'email', 'class' => 'form-control required', 'placeholder' => 'Email*', 'required']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                {!! Form::text('telephone',  null, ['id'=> 'telephone', 'class' => 'form-control', 'placeholder' => 'Telefon']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                {!! Form::text('name',null, ['id'=> 'name', 'class' => 'form-control required', 'placeholder' => 'Name*', 'required']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                {!! Form::text('clubname', null, ['id'=> 'clubname', 'class' => 'form-control', 'placeholder' => 'Verein']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="panel">
                    <fieldset>
                        <div class="form-group">
                            <div class="col-xs-12">
                                Bitte Ihre Anschrift angeben, wenn Sie eine Ergebnisliste w&uuml;nschen. <br> Beachten Sie auch die Wettkampfbedingungen.
                            </div>
                        </div>
                        <legend>Ergebnisliste</legend>
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('resultlist', '1', false, ['id'=>"resultBoxShowHide",'class'=>"minimal-red"])}} Ja, ich möchte eine Ergebnisliste </label>
                        </div>
                        <div class="form-group" id="resultBox" style="display:none;">
                            <div class="input-group">
                                {!! Form::text('street',  null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Strasse']) !!}
                            </div>
                            <br>
                            <div class="input-group">
                                {!! Form::text('city', null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Ort']) !!}
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <hr>
        <div id='participantGroup'>
            <div class="participant1">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('vorname[]',  null, ['id'=> '', 'class' => 'form-control required', 'placeholder' => 'Vorname*', 'required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('nachname[]',  null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Nachname*', 'required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('jahrgang[]', null, ['id'=> 'year', 'class' => 'form-control', 'placeholder' => 'Jahrgang*', 'required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::select('ageclass[]', $ageclasses , null, ['class' => 'form-control required', 'placeholder' => 'Altersklasse*','style'=>'width: 100%', 'required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        @if ($competition->season == 'cross')
                            {!! Form::text('discipline[]', null, ['required',  'class' => 'form-control', 'placeholder' => 'Disziplin*']) !!}
                        @else
                            {!! Form::select('discipline[]', $disciplines , null, ['required', 'class' => 'discipline_select form-control', 'placeholder' => 'Disziplin*', 'style'=>'width: 100%']) !!}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::text('bestzeit[]', null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Bestleistung']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Teilnehmer hinzufügen', array('id'=> 'addParticipant', 'class' => 'btn btn-outline-dark')) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        {!! Form::button('<i class="fa fa-pencil" aria-hidden="true">
                        </i>&nbsp;anmelden', array('class' => 'btn btn-outline-primary', 'type' => 'submit')) !!}
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
        @endsection
        @section('page-script')
            <script type="text/javascript">
                let ageclasses = {!! json_encode($ageclasses) !!};
                let disciplines = {!! json_encode($disciplines) !!};
                let season = {!! json_encode($competition->season) !!};
            </script>
            <script type="text/javascript" src="{{ url('/') }}/front/js/add_participator.js"></script>
        @stop
    </div>

