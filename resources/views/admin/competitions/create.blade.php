@extends('layouts.app')

@section('javascript')
    @parent

    <script>

    </script>

@stop
@section('content')
    <div class="container">
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create Competition
                </div>
                <div class="panel-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')
                {{ Form::open(['url'=>'admin/competitions', 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'csvuploader']) }}
                    @include('admin.competitions._form')
                    {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                    {!! Form::close() !!}
                    <div id="preview"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
