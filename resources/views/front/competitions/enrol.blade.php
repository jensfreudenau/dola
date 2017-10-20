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
                                            {{ Form::open(['url'=>'/competitions']) }}
                                            <div class="box box-default">
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                {!! Form::label('competition_header', Lang::get('quickadmin.competitions.title'), ['class' => 'control-label']) !!}:
                                                                {!! Form::select('competition_header', $competitionselect, ( $competition ? $competition->id: null), ['class' => 'form-control', 'id'=>'competition_id']) !!}

                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar fa-fw"></i>
                                                                    </span> <input class="form-control" placeholder="Datum" id="start_date" name="start_date" disabled value="{{ $competition ? Carbon\Carbon::parse($competition->start_date)->format('d.m.Y') : null}}">
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
                                                                    </span> <input class="form-control" placeholder="Email*" type="email" name="email"  required style="border-right: 2px solid red">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-phone fa-fw"></i>
                                                                    </span> <input class="form-control" placeholder="Telefon" name="telephone" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-user fa-fw"></i>
                                                                    </span> <input class="form-control" placeholder="Name*"  name="annunciator" type="text"  required style="border-right: 2px solid red">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-cog fa-fw"></i>
                                                                    </span> <input class="form-control" placeholder="Verein" name="clubname" type="text">
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
                                                                                <label> <input id="cbxShowHide" class="minimal-red" name="ergebisliste" type="checkbox">Ja, ich möchte eine Ergebnisliste </label>
                                                                            </div>
                                                                            <div class="form-group" id="block" style="display:none;">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-book fa-fw"></i>
                                                                                    </span>
                                                                                    <input class="form-control" placeholder="Strasse" id="street" name="street">
                                                                                </div>
                                                                                <br>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-book fa-fw"></i>
                                                                                    </span>
                                                                                    <input class="form-control" placeholder="Ort" id="city" name="city">
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
                                                                            <input class="form-control" name="vorname[]" placeholder="Vorname*" type="text" required style="border-right: 2px solid red">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>
                                                                            <input class="form-control" name="nachname[]" placeholder="Nachname*" type="text" required style="border-right: 2px solid red">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>
                                                                            <input class="form-control" name="jahrgang[]" placeholder="Jahrgang" type="text">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>
                                                                            <input class="form-control" name="altersklasse[]" placeholder="Altersklasse" type="text">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span>
                                                                            <input class="form-control" name="wettkampf[]" placeholder="Disziplin*" type="text" required style="border-right: 2px solid red">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>
                                                                            <input class="form-control" name="bestzeit[]" placeholder="Bestleistung" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-8">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <a class="btn btn-info btn-raised btn-lg btn-w-lg ui-wave  btn-xs" id='addButton'><i class="fa fa-pencil"></i> Teilnehmer hinzufügen</a>

                                                                </div>
                                                                </div>
                                                            </div>
                                                                <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <button class="btn btn-success btn-raised btn-lg btn-w-lg ui-wave btn-xs" type="submit" ng-transclude="" aria-label="Primary"><i class="fa fa-pencil"></i><span class="ng-scope">anmelden</span></button>
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
//        $(document).ready(function () {
            $('#cbxShowHide').is(':checked') ? $('#block').show() : $('#block').hide();
            $('#cbxShowHide').click(function () {
                this.checked ? $('#block').show(200) : $('#block').hide(200);
            });
            var counter = 2;

            $("#addButton").click(function () {
                $(this).removeAttr("href");
                var newTextBoxDiv = $(document.createElement('div')).attr("id", 'participant' + counter);
                newTextBoxDiv.after().html('<hr><div class="form-group"><div class="input-group"><span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
                    '<input class="form-control" name="vorname[]" placeholder="Vorname*" type="text" required style="border-right: 2px solid red"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
                    '<input class="form-control" name="nachname[]"placeholder="Nachname*" type="text" required style="border-right: 2px solid red"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>' +
                    '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang" type="text"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>' +
                    '<input class="form-control" name="altersklasse[]" placeholder="Altersklasse" type="text"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span>' +
                    '<input class="form-control" name="wettkampf[]" placeholder="Disziplin*" type="text" required style="border-right: 2px solid red"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>' +
                    '<input class="form-control" name="bestzeit[]" placeholder="Bestleistung" type="text"></div></div>');
                newTextBoxDiv.appendTo("#participantGroup");
                counter++;
            });


            /* Load positions into postion <selec> */
            $("#competition_id").change(function () {

                $.getJSON("/competitions/comps/" + $(this).val(), function (jsonData) {
                    $('#team_name').val(jsonData.team.name);
                    $('#header').val(jsonData.header);
                    let formatStartDate = $.datepicker.formatDate('dd.mm.yy', new Date(jsonData.start_date));
                    $('#start_date').val(formatStartDate);
                });
            });
//        });
    </script>

@endsection