@extends('layouts.front')
@section('head')
    <link rel="stylesheet" href="{{ url('/adminlte/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">
@endsection

@section('js')
    <script src="{{ url('/adminlte/js/dropzone.js') }}"></script>
    <script src="{{ url('/js/papaparse.min.js') }}"></script>
    <script src="{{ url('/js/dropzone-config.js') }}"></script>
    <script src="{{ url('/js/moment.min.js') }}"></script>
    <script>
        let ageclasses = {!! $ageclassesJson !!};
        let disciplines = {!! $disciplinesJson !!};
        let personalBestFormat = {!! $personalBestFormatJson !!};

        let contents = 'Forename;Name;Team;Ageclass;Discipline;Value;YOB\n' +
            'Lara;Bogumil;;MJU14;50m;00:00:02,55;2009\n' +
            'Lara;Bogumil;;MJU14;75m;0;2009\n' +
            'Juliane;Biermann;LAC Dortmund;WJU14;800m;0;2007\n' +
            'Juliane;Biermann;LAC Dortmund;WJU14;Speer;0;2007\n' +
            'Juliane;Biermann;LAC Dortmund;WJU14;1.500m;0:4:03.4;2007\n' +
            'Jens;Freudenau;LC Rapid Dortmund;WJU14;50;00:00:0,00;2009\n' +
            'Jens;Freudenau;LC Rapid Dortmund;MJU14;WEI;3,4;1969\n' +
            'Jens;Freudenau;LC Rapid Dortmund;MJU14;75;0;1969\n' +
            'Jens;Freudenau;LC Rapid Dortmund;MJU14;50;0;1969\n' +
            'Jens;Freudenau;LC Rapid Dortmund;MJU14;WEI;0;1969\n' +
            'Jens;Freudenau;LC Rapid Dortmund;MJU14;50;0;1969\n' +
            'Cassandra;Müller;TSC Eintracht Dortmund;WKU12;4X5;0;2009\n' +
            'Cassandra;Müller;TSC Eintracht Dortmund;WKU12;800;0;2009';
        processData(contents);

    </script>

@endsection
@section('content')

    <div class="card card-default mb-5 p-3">
        <h3>Massen Anmeldung 2</h3>

        <p class="desc">
        <span class="desc_type">Werte für die Altersklassen:</span> <br>
            @foreach ($competition->ageclasses as $ageclass)
                <span class="entry_tags">
                    {{$ageclass->ladv}}@if (!$loop->last)@endif
                </span>
            @endforeach
        </p>
        <p class="desc">
            <span class="desc_type">Werte für die Disziplinen:</span><br>
            @foreach ($competition->disciplines as $discipline)
                <span class="entry_tags">
                    {{$discipline->shortname}}@if (!$loop->last)@endif
                </span>
            @endforeach
        </p>
        <p class="desc">Nach 2 Stunden ist die Sitzung abgelaufen.</p>

        {{ Form::open(['url'=>'/announciators/masssave', 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'droppy']) }}
        <div class="form-group">
            <div class="input-group">
                <input class="form-control" placeholder="Veranstalter" disabled id="organizer_name"
                       name="organizer_name" value="{{ $competition ?  $competition->organizer->name : null}}">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                {!! Form::text('name',$announciator->name, ['id'=> 'name', 'class' => 'form-control required', 'placeholder' => 'Name*', 'required']) !!}
            </div>
        </div>
        <div class="form-group" id="">
            <div class="input-group">
                {!! Form::email('email',$announciator->email, ['id'=> 'email', 'class' => 'form-control required']) !!}
            </div>
        </div>
<span id="mycsvdata"> </span>
        <div class="dz-message" data-dz-message><div class="message">CSV Datei hier hin ziehen oder klicken</div></div>
        <div class="fallback">
            <input type="file" name="file" multiple>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <div class="form-group float-right">
                    <div class="input-group">
                        {!! Form::button('<i class="fa fa-pencil" aria-hidden="true">
                        </i>&nbsp;hochladen', array('id'=>'upload', 'class' => 'btn btn-outline-primary', 'type' => 'submit')) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('massupload', true) !!}
        {!! Form::hidden('hash',$announciator->hash) !!}
        {!! Form::hidden('competition_id',$competition->id) !!}
        {!! Form::close() !!}
    </div>
@endsection

