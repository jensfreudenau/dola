@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.competitions.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.competitions.update') :: {{$competition->header}}
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    {!! Form::model($competition, ['method' => 'PUT', 'route' => ['admin.competitions.update', $competition->id]]) !!}
                    @include('admin.competitions._form')
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            {!! Form::submit('Speichern', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="page-header">

            </div>
            @include('partials.admin.modal')
            <div class="row">
                <div class="col-sm-10">
                    <div class="box box-default">

                        <div class="box-body">
                            <table class="table" data-toggle="dataTable" data-form="deleteForm">
                                <thead>
                                    <tr><td colspan="2"><h3>Teilnehmerlisten</h3></td></tr>
                                </thead>
                                <tbody>
                                @foreach ($competition->uploads as $uploads)
                                    @if($uploads->type == 'participator')
                                        @include('partials.admin.filelist', ['uploads' => $uploads])
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                    {!! Form::model($competition, ['method' => 'POST', 'url'=>'admin/competitions/participator/'.$competition->id, 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'participator']) !!}
                    <div class="dz-message" data-dz-message><span>Teilnehmerliste hier hin ziehen</span></div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="page-header">

            </div>
            <div class="row">
                <div class="col-sm-10">
                    <div class="box box-default">

                        <div class="box-body">
                            <table class="table" data-toggle="dataTable" data-form="deleteForm">
                                <thead>
                                <tr>
                                    <td colspan="2"><h3>Ergebnislisten</h3></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($competition->uploads as $uploads)
                                    <tr>
                                        @if($uploads->type == 'resultsets')
                                            @include('partials.admin.filelist', ['uploads' => $uploads])
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                    {!! Form::model($competition, ['method' => 'POST', 'url'=>'admin/competitions/resultsets/'.$competition->id, 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'resultsets']) !!}
                    <div class="dz-message" data-dz-message><span>Ergebnisliste hier hin ziehen</span></div>
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
        $(document).ready(function () {
            $('.datepicker').datepicker({
                autoclose: true,
                format: "dd.mm.yyyy"
            });
            $('table[data-form="deleteForm"]').on('click', '.form-delete', function (e) {
                e.preventDefault();
                var $form = $(this);
                $('#confirm').modal({backdrop: 'static', keyboard: false})
                    .on('click', '#delete-btn', function () {
                        $form.submit();
                    });
            });
        });
    </script>

@stop