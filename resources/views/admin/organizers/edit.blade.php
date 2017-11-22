@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.organizers.title')</h3>

    {!! Form::model($organizer, ['method' => 'PUT', 'route' => ['admin.organizers.update', $organizer->id]]) !!}

    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    @include('admin.organizers._form')
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

