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
                    {!! Form::model($record, ['method' => 'PUT', 'route' => ['admin.records.update', $record->id]]) !!}

                    <div class="form-group">
                        {!! Form::label('header', Lang::get('quickadmin.header')) !!}
                        {!! Form::text('header', null, ['id'=> 'record-headline', 'class'=>'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('records_table', Lang::get('quickadmin.records_table')) !!}
                        {!! Form::textarea('records_table', null, ['id'=> 'record-records_table', 'class'=>'form-control']) !!}
                    </div>
                    {{ Form::submit() }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection