@extends('layouts.front')
@section('head')
    <link rel="stylesheet" href="{{ url('/adminlte/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    </script>

@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card card-default mb-5 p-3">
        <h3>Anmeldung Upload</h3>
        <h4>{{$competition->header}}</h4>
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
        {{csrf_field()}}
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

