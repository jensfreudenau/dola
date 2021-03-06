@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.participators.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.participators.store']]) !!}

    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    {!! Form::label('organizer_id', 'Organizer', ['class' => 'control-label']) !!}
                    {!! Form::select('organizer_id', $organizers, old('organizer_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('organizer_id'))
                        <p class="help-block">
                            {{ $errors->first('organizer_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    {!! Form::label('surname', 'Surname', ['class' => 'control-label']) !!}
                    {!! Form::text('surname', old('surname'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('surname'))
                        <p class="help-block">
                            {{ $errors->first('surname') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    {!! Form::label('birth_date', 'Birth date', ['class' => 'control-label']) !!}
                    {!! Form::text('birth_date', old('birth_date'), ['class' => 'form-control date', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('birth_date'))
                        <p class="help-block">
                            {{ $errors->first('birth_date') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });
    </script>

@stop