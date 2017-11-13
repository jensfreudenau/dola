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
