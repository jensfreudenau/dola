@extends('layouts.app')

@section('javascript')
    @parent
@stop
@section('content')
<div class="container">
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                Create Records
            </div>
            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')
                {{ Form::open(['url'=>'admin/records', 'enctype'=>'multipart/form-data', 'id' => 'recorduploader']) }}
                <div class="form-group">
                    {!! Form::label('header', Lang::get('quickadmin.records.fields.header')) !!}
                    {!! Form::text('header', null, ['id'=> 'record-headline', 'class'=>'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('sex', Lang::get('quickadmin.records.fields.sex')) !!}<br>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary ">
                            {{ Form::radio('sex', 'f', 0) }} @lang('quickadmin.records.female')
                        </label> <label class="btn btn-primary">
                            {{ Form::radio('sex', 'm', 0) }} @lang('quickadmin.records.male')
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('records_table', Lang::get('quickadmin.records.table')) !!}
                    {!! Form::textarea('records_table', null, ['id'=> 'record-records_table', 'class'=>'form-control']) !!}
                </div>
                {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection