@extends('layouts.front')
@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="page  ng-scope">
            <section class="panel panel-default">
                <div class="invoice-inner">
                    <div class="row">
                        <div class="col-xs-10">
                            <section class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-10">
                                            {!! Form::open(['method' => 'POST', 'route' => ['teams/store']]) !!}
                                            <div class="box box-default">
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                {!! Form::label('competition_id', Lang::get('quickadmin.competitions.title'), ['class' => 'control-label']) !!}:
                                                                {!! Form::select('competition_id', $competitionselect, ( $competition ? $competition->id: null), ['id'=> '', 'class' => 'form-control']) !!}

                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar fa-fw"></i>
                                                                    </span>
                                                                    <input class="form-control" placeholder="Datum" id="start_date" name="start_date" disabled value="{{$competition->start_date}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-star fa-fw"></i>
                                                                    </span> <input class="form-control" placeholder="Titel" id="header" name="header" disabled value="{{ $competition ?  $competition->header : null}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-circle fa-fw"></i>
                                                                    </span> <input class="form-control" placeholder="Veranstalter" disabled id="team_name" name="team_name" value="{{ $competition ?  $competition->team->name : null}}">
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-envelope fa-fw"></i>
                                                                    </span>
                                                                    {!! Form::email('email', $value = null, ['id'=> 'email', 'class' => 'form-control required', 'placeholder' => 'Email*', 'required']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-phone fa-fw"></i>
                                                                    </span>
                                                                    {!! Form::text('telephone', $value = null, ['id'=> 'telephone', 'class' => 'form-control', 'placeholder' => 'Telefon']) !!}

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-user fa-fw"></i>
                                                                    </span>
                                                                    {!! Form::text('annunciator', $value = null, ['id'=> 'annunciator', 'class' => 'form-control required', 'placeholder' => 'Name*', 'required']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-cog fa-fw"></i>
                                                                    </span>
                                                                    {!! Form::text('clubname', $value = null, ['id'=> 'clubname', 'class' => 'form-control', 'placeholder' => 'Verein']) !!}
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
                                                                                    {{Form::checkbox('resultlist', '1', false, ['id'=>"cbxShowHide",'class'=>"minimal-red"])}}

                                                                                    Ja, ich möchte eine Ergebnisliste </label>
                                                                            </div>
                                                                            <div class="form-group" id="block" style="display:none;">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-book fa-fw"></i>
                                                                                    </span>
                                                                                    {!! Form::text('street', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Strasse']) !!}
                                                                                </div>
                                                                                <br>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-book fa-fw"></i>
                                                                                    </span>
                                                                                    {!! Form::text('city', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Ort']) !!}
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
                                                                            <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>
                                                                            {!! Form::text('vorname[]', $value = null, ['id'=> '', 'class' => 'form-control required', 'placeholder' => 'Vorname*', 'required']) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>
                                                                            {!! Form::text('nachname[]', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Nachname']) !!}
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>
                                                                            {!! Form::text('jahrgang[]', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Jahrgang']) !!}
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>
                                                                            {!! Form::text('altersklasse[]', $value = null, ['id'=> '', 'class' => 'form-control required', 'placeholder' => 'Altersklasse', 'required']) !!}
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span>
                                                                            {!! Form::text('wettkampf[]', $value = null, ['class' => 'form-control required', 'placeholder' => 'Disziplin*', 'required']) !!}
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>
                                                                            {!! Form::text('bestzeit[]', $value = null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Bestleistung']) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <a class="btn btn-info btn-raised btn-lg btn-w-lg ui-wave  btn-xs" id='addParticipant'><i class="fa fa-plus"></i> Teilnehmer hinzufügen</a>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i><span class="ng-scope">anmelden</span>', array('type' => 'submit', 'class' => 'btn btn-success btn-raised btn-lg btn-w-lg ui-wave btn-xs')) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            {!! Form::close() !!}

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div class="divider divider-lg"></div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-2"></div>

    <script>
        $(document).ready(function () {
            $('#cbxShowHide').is(':checked') ? $('#block').show() : $('#block').hide();
            $('#cbxShowHide').click(function () {
                this.checked ? $('#block').show(200) : $('#block').hide(200);
            });
            var counter = 2;

            $("#addParticipant").click(function () {
                $(this).removeAttr("href");
                let newTextBoxDiv = $(document.createElement('div')).attr("id", 'participant' + counter);
                newTextBoxDiv.after().html('<hr><div class="form-group"><div class="input-group"><span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
                    '<input class="form-control required" name="vorname[]" placeholder="Vorname*" type="text" required></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
                    '<input class="form-control" name="nachname[]" placeholder="Nachname" type="text"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>' +
                    '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang" type="text"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>' +
                    '<input class="form-control required" name="altersklasse[]" placeholder="Altersklasse" type="text" required></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span>' +
                    '<input class="form-control required" name="wettkampf[]" placeholder="Disziplin*" type="text" required></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>' +
                    '<input class="form-control" name="bestzeit[]" placeholder="Bestleistung" type="text"></div></div>');
                newTextBoxDiv.appendTo("#participantGroup");
                counter++;
            });
        });
        /* Load positions into postion <selec> */
        $("#competition_id").change(function () {
            $.getJSON("/teams/competitions_select/" + $(this).val(), function (jsonData) {
                $('#team_name').val(jsonData.team.name);
                $('#header').val(jsonData.header);
                $('#start_date').val(jsonData.start_date);
            });
        });
    </script>

@endsection