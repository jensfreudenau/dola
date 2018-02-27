@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>

    <div class="card card-default">
        <div class="card-heading">
            <h4>@lang('quickadmin.competitions.update') :: {{$competition->header}}</h4>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-10">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    {!! Form::model($competition, ['method' => 'PUT', 'route' => ['admin.competitions.update', $competition->id]]) !!}
                    @include('admin.competitions._form', ['disabled' => false])
                    @if($additionals)
                        @foreach($additionals as $key => $additional)
                            <div class="form-group">
                                {!! Form::label('keyvalue['.$additional->id. '][key]', Lang::get('quickadmin.competitions.fields.key')) !!}
                                {!! Form::text('keyvalue['.$additional->id. '][key]', $additional->key, ['id'=> 'additional-key_'.$additional->id, 'class'=>'form-control']) !!}

                            </div>
                            <div class="form-group">
                                {!! Form::label('keyvalue['.$additional->id. '][value]', Lang::get('quickadmin.competitions.fields.value')) !!}
                                {!! Form::text('keyvalue['.$additional->id. '][value]', $additional->value, ['id'=> 'additional-value_'.$additional->id, 'class'=>'form-control']) !!}
                            </div>
                            <hr>
                        @endforeach
                    @endif
                    <div id="additionalGroup"></div>
                    <div class="form-group">
                        <div class="input-group">
                            {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Werte hinzufügen', array('id'=> 'addValues', 'class' => 'btn btn-outline-dark')) !!}
                        </div>
                    </div>
                    {!! Form::submit('Speichern', ['class' => 'btn btn-lg btn-info pull-right margin-bottom'] ) !!}
                    <br>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" data-toggle="dataTable" data-form="deleteForm">
                                <thead>
                                <tr>
                                    <td colspan="2"><h3>Dateien</h3></td>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($competition->uploads as $uploads)
                                        <tr>
                                            @if($uploads->type == 'additionals')
                                                @include('partials.admin.filelist', ['uploads' => $uploads])
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {!! Form::model($competition, ['method' => 'POST', 'url'=>'admin/competitions/uploader/'.$competition->id, 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'additionals']) !!}
                            <div class="dz-message" data-dz-message><span>Datei hier hin ziehen</span></div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" data-toggle="dataTable" data-form="deleteForm">
                                <thead>
                                <tr><td colspan="2"><h3>Teilnehmerlisten</h3></td></tr>
                                </thead>
                                <tbody>
                                @foreach ($competition->uploads as $uploads)
                                    @if($uploads->type == 'participators')
                                        @include('partials.admin.filelist', ['uploads' => $uploads])
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                            {!! Form::model($competition, ['method' => 'POST', 'url'=>'admin/competitions/uploader/'.$competition->id, 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'participators']) !!}
                            <div class="dz-message" data-dz-message><span>Teilnehmerliste hier hin ziehen</span></div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row"><div class="col-sm-10"></div></div>

            <div class="row">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" data-toggle="dataTable" data-form="deleteForm">
                                <thead>
                                <tr>
                                    <td colspan="2"><h3>Ergebnislisten</h3></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($competition->uploads as $uploads)
                                    <tr>
                                        @if($uploads->type == 'resultsets')
                                            @include('partials.admin.filelist', ['uploads' => $uploads])
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {!! Form::model($competition, ['method' => 'POST', 'url'=>'admin/competitions/uploader/'.$competition->id, 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'resultsets']) !!}
                            <div class="dz-message" data-dz-message><span>Ergebnisliste hier hin ziehen</span></div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>


            <p>&nbsp;</p>
            <a href="{{ route('admin.competitions.index') }}"
               class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>



@endsection
@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/bootstrap-datepicker.js"></script>

    <script src="{{ url('quickadmin/js') }}/add_additional.js"></script>

@stop