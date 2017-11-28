@extends('layouts.front')
@section('content')
    <h3>Anmeldung</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['announciators/store']]) !!}
    <div class="form-group">
        {!! Form::label('competition_id', Lang::get('quickadmin.competitions.title'), ['class' => 'control-label']) !!}: {!! Form::select('competition_id', $competitionselect, ( $competition ? $competition->id: null), ['id'=> 'competition_id', 'class' => 'competition_select form-control']) !!}
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
            <input class="form-control" placeholder="Datum" id="start_date" name="start_date" disabled value="{{ $competition ?  $competition->start_date : null}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-star fa-fw"></i></span>
            <input class="form-control" placeholder="Titel" id="header" name="header" disabled required value="{{ $competition ?  $competition->header : null}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-circle fa-fw"></i></span>
            <input class="form-control" placeholder="Veranstalter" disabled id="organizer_name" name="organizer_name" value="{{ $competition ?  $competition->organizer->name : null}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span> {!! Form::email('email', $value = null, ['id'=> 'email', 'class' => 'form-control required', 'placeholder' => 'Email*', 'required']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span> {!! Form::text('telephone', $value = null, ['id'=> 'telephone', 'class' => 'form-control', 'placeholder' => 'Telefon']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span> {!! Form::text('name', $value = null, ['id'=> 'name', 'class' => 'form-control required', 'placeholder' => 'Name*', 'required']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-cog fa-fw"></i></span> {!! Form::text('clubname', $value = null, ['id'=> 'clubname', 'class' => 'form-control', 'placeholder' => 'Verein']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="panel">
                <fieldset>
                    <div class="form-group">
                        <div class="col-xs-12">
                            Bitte Ihre Anschrift angeben, wenn Sie eine Ergebnisliste w&uuml;nschen.
                            <br> Beachten Sie auch die Wettkampfbedingungen.
                        </div>
                    </div>
                    <legend>Ergebnisliste</legend>
                    <div class="form-group">
                        <label>
                            {{Form::checkbox('resultlist', '1', false, ['id'=>"cbxShowHide",'class'=>"minimal-red"])}} Ja, ich möchte eine Ergebnisliste </label>
                    </div>
                    <div class="form-group" id="block" style="display:none;">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span> {!! Form::text('street', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Strasse']) !!}
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span> {!! Form::text('city', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Ort']) !!}
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <hr>
    <style>
        .fa-close {
            color: darkred;
        }
    </style>
    <div id='participantGroup'>
        <div class="participant1">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span> {!! Form::text('vorname[]', $value = null, ['id'=> '', 'class' => 'form-control required', 'placeholder' => 'Vorname*', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span> {!! Form::text('nachname[]', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Nachname*', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span> {!! Form::text('jahrgang[]', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Jahrgang']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span> {!! Form::text('altersklasse[]', $value = null, ['id'=> '', 'class' => 'form-control required', 'placeholder' => 'Altersklasse*', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span> {!! Form::text('wettkampf[]', $value = null, ['class' => 'form-control required', 'placeholder' => 'Disziplin*', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span> {!! Form::text('bestzeit[]', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Bestleistung']) !!}
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
                    {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;anmelden', array('class' => 'btn btn-outline-primary', 'type' => 'submit')) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection