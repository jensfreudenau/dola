@extends('layouts.app')

@section('javascript')
    @parent
@stop
@section('content')
    <div class="container">
        <div class="col-sm-10">
            <div class="card card-default">
                <div class="card-heading">
                    Create Records
                </div>
                <div class="card-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')



                    {{ Form::open(['url'=>'admin/records/beststore', 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'recorduploader']) }}
                    
                    <div class="form-group">
                        {!! Form::label('year', Lang::get('quickadmin.records.fields.year')) !!}
                        {!! Form::text('year', null, ['id'=> 'record-year', 'class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('sex', Lang::get('quickadmin.records.fields.sex')) !!}<br>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary ">
                                {{ Form::radio('sex', 'f', 0) }} @lang('quickadmin.records.female')
                            </label>
                            <label class="btn btn-primary">
                                {{ Form::radio('sex', 'm', 0) }} @lang('quickadmin.records.male')
                            </label>
                        </div>
                    </div>
                    <div class="dz-message" data-dz-message><span>Datei hier hin ziehen</span></div>

                    {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection