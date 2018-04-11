@extends('layouts.app')
@section('content')
    <h3 class="page-title">@lang('quickadmin.organizers.title')</h3>
    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.qa_edit')
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    @include('common.errors')
                    {!! Form::model($organizer, ['method' => 'PUT', 'route' => ['admin.organizers.update', $organizer->id]]) !!}
                    {{ csrf_field() }}
                    @include('admin.organizers._form')
                    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection

