@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.competitions.update') :: {{$competition->header}}
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                        <!-- Display Validation Errors -->
                    @include('common.errors')

                    {!! Form::model($competition, ['method' => 'PUT', 'route' => ['admin.competitions.update', $competition->id]]) !!}
                    @include('admin.competitions._form')
                    {{ Form::submit() }}
                    {!! Form::close() !!}
                </div>
            </div>
            <p>&nbsp;</p>
            <a href="{{ route('admin.competitions.index') }}"
               class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/bootstrap-datepicker.js"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format: "dd.mm.yyyy"
        });
    </script>

@stop