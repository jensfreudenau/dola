@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.teams.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.teams.store']]) !!}

    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    @include('admin.teams._form')
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                            {{ $errors->first('homepage') }}
                            {{ $errors->first('head_of') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

