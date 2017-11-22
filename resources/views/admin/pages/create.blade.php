@extends('layouts.app')

@section('javascript')
    @parent
@stop
@section('content')
    <div class="container">
        <div class="col-sm-10">
            <div class="card card-default">
                <div class="card-heading">
                    Create Page
                </div>
                <div class="card-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                    {{ Form::open(['url'=>'admin/pages', 'id' => 'recorduploader']) }}
                            {{ csrf_field() }}
                            @include ('admin.pages.form')
                    {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
