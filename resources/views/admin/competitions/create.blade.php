@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create Competition
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')
                {{ Form::open(['url'=>'admin/competitions', 'enctype'=>'multipart/form-data']) }}

                <!-- New Competition Form -->
                    @include('admin.competitions._form')
                    {{ Form::submit() }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/bootstrap-datepicker.js"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format: "dd.mm.yyyy",
            language: 'de-DE'
        });
    </script>

@stop