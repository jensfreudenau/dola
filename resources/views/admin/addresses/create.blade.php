@extends('layouts.app')

@section('javascript')
    @parent
@stop
@section('content')
    <div class="container">
        <div class="col-sm-10">
            <div class="card card-default">
                <div class="card-heading">
                    <h4>@lang('quickadmin.qa_create')</h4>
                </div>
                <div class="card-body">
                    @include('common.errors')
                    {{ Form::open(['url'=>'admin/addresses', 'id' => 'addresses']) }}
                    @include ('admin.addresses._form')
                    {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
