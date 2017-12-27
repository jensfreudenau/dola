@extends('layouts.front')
@section('content')

    <h3>Anmeldung</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['announciators/store']]) !!}
    <div class="form-group">
        {!! Form::label('competition_id', Lang::get('quickadmin.competitions.title'), ['class' => 'control-label']) !!}
        {!! Form::select('competition_id', $competitionselect, ( $competition ? $competition->id: null), ['id'=> 'competition_id', 'class' => 'competition_select form-control','style'=>'width: 100%']) !!}
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span> <input class="form-control" placeholder="Datum" id="start_date" name="start_date" disabled value="{{ $competition ?  $competition->start_date : null}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-star fa-fw"></i></span> <input class="form-control" placeholder="Titel" id="header" name="header" disabled required value="{{ $competition ?  $competition->header : null}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-circle fa-fw"></i></span> <input class="form-control" placeholder="Veranstalter" disabled id="organizer_name" name="organizer_name" value="{{ $competition ?  $competition->organizer->name : null}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
            {!! Form::email('email',null, ['id'=> 'email', 'class' => 'form-control required', 'placeholder' => 'Email*', 'required']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
            {!! Form::text('telephone',  null, ['id'=> 'telephone', 'class' => 'form-control', 'placeholder' => 'Telefon']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
            {!! Form::text('name',null, ['id'=> 'name', 'class' => 'form-control required', 'placeholder' => 'Name*', 'required']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-cog fa-fw"></i></span>
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
                            {{Form::checkbox('resultlist', '1', false, ['id'=>"cbxShowHide",'class'=>"minimal-red"])}} Ja, ich möchte eine Ergebnisliste </label>
                    </div>
                    <div class="form-group" id="block" style="display:none;">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>
                            {!! Form::text('street',  null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Strasse']) !!}
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>
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
                    <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span> {!! Form::text('vorname[]',  null, ['id'=> '', 'class' => 'form-control required', 'placeholder' => 'Vorname*', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span> {!! Form::text('nachname[]',  null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Nachname*', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>
                    {!! Form::text('jahrgang[]', null, ['id'=> '', 'class' => 'form-control', 'placeholder' => 'Jahrgang']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>
                    @if ($competition->season == 'cross')
                        {!! Form::text('ageclass[]', null, ['required',  'class' => 'form-control', 'placeholder' => 'Altersklasse*']) !!}
                    @else
                        {!! Form::select('ageclass[]', $ageclasses , null, ['class' => 'form-control required', 'placeholder' => 'Altersklasse*', 'required','style'=>'width: 100%']) !!}
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span>
                    @if ($competition->season == 'cross')
                        {!! Form::text('discipline[]', null, ['required',  'class' => 'form-control', 'placeholder' => 'Disziplin*']) !!}
                    @else
                        {!! Form::select('discipline[]', $disciplines , null, ['required', 'class' => 'discipline_select form-control', 'placeholder' => 'Disziplin*', 'style'=>'width: 100%']) !!}
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>
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

        let ageclassesOption = '';
        let disciplinesOption = '';
        $(document).ready(function () {
            $.each(disciplines, function (index, value) {
                disciplinesOption += '<option value="' + index + '">' + value + '</option>';
            });
            $.each(ageclasses, function (index, value) {
                ageclassesOption += '<option value="' + index + '">' + value + '</option>';
            });
            $('.dropdown-toggle').dropdown();
            $('#cbxShowHide').is(':checked') ? $('#block').show() : $('#block').hide();
            $('#cbxShowHide').click(function () {
                this.checked ? $('#block').show(200) : $('#block').hide(200);
            });
            var counter = 1;
            $('#participantGroup').on('click', '.remove', function () {
                $(this).parent().remove();
            });

            $("#addParticipant").click(function () {
                let ageclassSelect;
                let disciplineSelect;
                if (season == 'cross') {
                    disciplineSelect = '<input class="form-control required" name="discipline[]" placeholder="Disziplin*" type="text" required></div></div>';
                    ageclassSelect = '<input class="form-control required" name="ageclass[]" placeholder="Altersklasse*" type="text" required></div></div>';
                }
                else {
                    disciplineSelect = '<select name=discipline[]  class="discipline_select form-control" required placeholder = "Disziplin*" style="width: 100%;">' + disciplinesOption + '</select></div></div>';
                    ageclassSelect = '<select name=ageclass[]  class="ageclass_select form-control" required placeholder = "Altersklasse*" style="width: 100%;">' + ageclassesOption + '</select></div></div>';
                }

                $(this).removeAttr("href");
                let newTextBoxDiv = $(document.createElement('div')).attr("id", 'participant' + counter);
                newTextBoxDiv.after().html('<hr>' +
                    '<button type="button" id="remove_' + counter + '" class="remove close btn btn-outline-danger mb-2" aria-label="Close">' +
                    '<i class="fa fa-close fa-fw"></i><span aria-hidden="true"></span></button>' +
                    '<div class="form-group"><div class="input-group"><span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
                    '<input class="form-control required" name="vorname[]" placeholder="Vorname*" type="text" required></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
                    '<input class="form-control" name="nachname[]" placeholder="Nachname*" required type="text"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>' +
                    '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang" type="text"></div></div>' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>'
                    + ageclassSelect +
                    '<div class="form-group">' +
                    '<div class="input-group ">' +
                    '<span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span>'
                    + disciplineSelect +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>' +
                    '<input class="form-control" name="bestzeit[]" placeholder="Bestleistung" type="text"></div></div>');
                newTextBoxDiv.appendTo("#participantGroup");


                counter++;
            });
        });
    </script>
@stop

