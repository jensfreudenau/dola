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
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                    {!! Form::model($page, ['method' => 'PUT', 'route' => ['admin.pages.update', $page->id]]) !!}

                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}



                    @include ('admin.pages.form')
                    {{ Form::submit('Update', ["class"=>"btn btn-primary pull-right"]) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
