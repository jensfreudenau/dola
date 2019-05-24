@extends('layouts.app')

@section('javascript')
    @parent
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <div class="card card-default">
                    <div class="card-title">
                        <h2>Create Competition</h2>
                    </div>
                    <div class="card-body">
                        @include('common.errors')
                        {{ Form::open(['url'=>'admin/competitions', 'enctype'=>'multipart/form-data', 'class'=>'dropzone', 'id' => 'csvuploader']) }}
                            @if (count($errors) > 0)
                            <div class="form-group">
                                {!! Form::label('ignore_error', 'ignore_error') !!}
                                {!! Form::checkbox('ignore_error', 'ignore' , null, ['div' => 'cliente']) !!}
                            </div>
                            @endif
                        @include('admin.competitions._form', ['disabled' => true])
                        <div id="additionalGroup"></div>
                        <div class="form-group">
                            <div class="input-group">
                                {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Werte hinzufügen', array('id'=> 'addValues', 'class' => 'btn btn-outline-dark')) !!}
                            </div>
                        </div>
                        {{ Form::submit('Speichern', ["class"=>"btn btn-primary pull-right"]) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            var counter = 0;
            $("#addValues").click(function () {
                $(this).removeAttr("href");
                let newTextBoxDiv = $(document.createElement('div'));
                newTextBoxDiv.after().html(
                    '<div class="form-group">' +
                    '<label for="additional-key_' + counter + '">Key</label>' +
                    '<input id="additional-key_' + counter + '" class="form-control" name="keyvalue[' + counter + '][key]" type="text">' +
                    '</div><div class="form-group">' +
                    '<label for="additional-value_' + counter + '">Value</label>' +
                    '<input id="additional-value_' + counter + '" class="form-control" name="keyvalue[' + counter + '][value]" type="text">' +
                    '</div>'
                );
                newTextBoxDiv.appendTo("#additionalGroup");
                counter++;
            });
        });
    </script>
@endsection
