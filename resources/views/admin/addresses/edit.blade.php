@extends('layouts.app')
@section('content')
    <h3 class="page-title">@lang('quickadmin.pages.title')</h3>
    <div class="card card-default">
        <div class="card-heading">
            @lang('quickadmin.qa_edit')
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    @include('common.errors')
                    {!! Form::model($address, ['method' => 'PUT', 'route' => ['admin.addresses.update', $address->id]]) !!}

                    {{ csrf_field() }}
                    @include ('admin.addresses._form')
                    {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
